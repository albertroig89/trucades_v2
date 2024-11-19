<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class JobsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $jobs;

    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    /**
     * Retornar la colección de trabajos
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $groupedJobs = $this->jobs->groupBy('client_id');
        $exportCollection = new Collection();

        foreach ($groupedJobs as $clientJobs) {
            $clientTotalMinutes = $clientJobs->sum('totalmin');
            $clientName = $clientJobs->first()->clientname;

            // Agregar cada trabajo del cliente
            foreach ($clientJobs as $job) {
                $exportCollection->push($job);
            }

            // Agregar la fila con el total de minutos del cliente
            $exportCollection->push((object) [
                'user' => null,
                'clientname' => 'Minutos totales para "' . $clientName . '"',
                'job' => '',
                'attempts' => '',
                'inittime' => '',
                'endtime' => '',
                'totalmin' => $clientTotalMinutes . ' min (' . number_format($clientTotalMinutes / 60, 2) . ' horas)',
            ]);
        }

        return $exportCollection;
    }

    /**
     * Definir las cabeceras del archivo Excel
     * @return array
     */
    public function headings(): array
    {
        return [
            'Empleado',
            'Cliente',
            'Trabajo realizado',
            'Intentos',
            'Inicio del trabajo',
            'Fin del trabajo',
            'Tiempo empleado',
        ];
    }

    /**
     * Mapear los datos para incluir solo los necesarios en las columnas correctas
     * @param mixed $job
     * @return array
     */
    public function map($job): array
    {
        return [
            $job->user ? $job->user->name : '',                   // Nombre del empleado
            $job->clientname,                                     // Nombre del cliente
            $job->job,                                            // Trabajo realizado
            $job->attempts,                                       // Intentos
            $job->inittime ? \Carbon\Carbon::parse($job->inittime)->format('d-m-Y H:i') : '',  // Inicio del trabajo
            $job->endtime ? \Carbon\Carbon::parse($job->endtime)->format('d-m-Y H:i') : '',   // Fin del trabajo
            is_numeric($job->totalmin) ? $job->totalmin . ' min' : $job->totalmin,            // Tiempo empleado
        ];
    }

    /**
     * Eventos para ajustar el ancho de columnas automáticamente, establecer un ancho fijo, aplicar estilos y congelar fila de cabeceras
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ajustar automáticamente el tamaño de todas las columnas excepto la columna 'C' (Trabajo realizado)
                foreach (['A', 'B', 'D', 'E', 'F', 'G'] as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Establecer un ancho fijo en la columna 'C' (Trabajo realizado)
                $sheet->getColumnDimension('C')->setWidth(40);

                // Aplicar estilo negrita a las cabeceras y cambiar el fondo a gris claro
                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'D9D9D9', // Gris claro
                        ],
                    ],
                ]);

                // Congelar la primera fila (cabeceras)
                $sheet->freezePane('A2');

                // Obtener las filas para fusionar y dar formato de totales
                $currentRow = 2; // Comienza desde la segunda fila después del encabezado

                foreach ($this->jobs->groupBy('client_id') as $clientJobs) {
                    $totalRow = $currentRow + count($clientJobs); // Determina la fila de total

                    // Fusionar columnas A y B para la descripción del total
                    $sheet->mergeCells("A{$totalRow}:B{$totalRow}");
                    // Fusionar columnas F y G para el total de tiempo
                    $sheet->mergeCells("F{$totalRow}:G{$totalRow}");

                    // Aplicar negrita a la fila de totales y cambiar el fondo a gris claro
                    $sheet->getStyle("A{$totalRow}:G{$totalRow}")->applyFromArray([
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'E3E3E3', // Gris claro
                            ],
                        ],
                    ]);

                    // Alinear el contenido de la descripción del total a la izquierda y el total de tiempo a la derecha
                    $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle("F{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                    // Asegurar que el contenido de la fila de totales esté bien definido y visible
                    $sheet->setCellValue("A{$totalRow}", 'Minutos totales para "' . $clientJobs->first()->clientname . '"');
                    $sheet->setCellValue("F{$totalRow}", $clientJobs->sum('totalmin') . ' min (' . number_format($clientJobs->sum('totalmin') / 60, 2) . ' horas)');

                    // Avanzar la posición actual a la siguiente sección
                    $currentRow = $totalRow + 1;
                }

                // Calcular el total de todos los minutos de los trabajos
                $totalMinutes = $this->jobs->sum('totalmin');
                $totalHours = number_format($totalMinutes / 60, 2);

                // Fila de total de todos los trabajos
                $totalAllRow = $currentRow + 1;

                // Fusionar todas las celdas de la fila para el total
                $sheet->mergeCells("A{$totalAllRow}:G{$totalAllRow}");

                // Aplicar estilo negrita y alineación a la derecha
                $sheet->getStyle("A{$totalAllRow}:G{$totalAllRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                // Establecer el contenido de la celda
                $sheet->setCellValue("A{$totalAllRow}", "Tiempo total de todos los trabajos: {$totalMinutes} minutos ({$totalHours} horas)");
            },
        ];
    }

}





