<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelJobsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $jobs;
    protected $title;

    public function __construct($jobs, $inittime, $endtime)
    {
        $this->jobs = $jobs;
        $this->title = 'Exportación de trabajos a excel entre ' . \Carbon\Carbon::parse($inittime)->format('d-m-y') . ' y el ' . \Carbon\Carbon::parse($endtime)->format('d-m-y');
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
            $job->inittime ? \Carbon\Carbon::parse($job->inittime)->format('d-m-y H:i') : '',  // Inicio del trabajo
            $job->endtime ? \Carbon\Carbon::parse($job->endtime)->format('d-m-y H:i') : '',   // Fin del trabajo
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

                // Añadir el título al Excel en la primera fila
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', $this->title);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Asegurarse de añadir las cabeceras en la fila 2
                $sheet->fromArray($this->headings(), null, 'A2');

                // Ajustar automáticamente el tamaño de todas las columnas excepto la columna 'C' (Trabajo realizado)
                foreach (['A', 'B', 'D', 'E', 'F', 'G'] as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Establecer un ancho fijo en la columna 'C' (Trabajo realizado)
                $sheet->getColumnDimension('C')->setWidth(40);

                // Aplicar estilo negrita a las cabeceras y cambiar el fondo a gris claro
                $sheet->getStyle('A2:G2')->applyFromArray([
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

                // Congelar las primeras dos filas (título y cabeceras)
                $sheet->freezePane('A3');

                // Ajustar la variable de la fila actual para comenzar los datos desde la fila 3
                $currentRow = 3;

                // Iterar sobre los trabajos agrupados por cliente
                foreach ($this->jobs->groupBy('client_id') as $clientJobs) {
                    // Insertar cada trabajo del cliente
                    foreach ($clientJobs as $job) {
                        $sheet->fromArray($this->map($job), null, "A{$currentRow}");
                        $currentRow++;
                    }

                    // Determinar la fila del total para el cliente actual
                    $totalRow = $currentRow;

                    // Crear la fila de totales del cliente con los valores apropiados
                    $sheet->mergeCells("A{$totalRow}:B{$totalRow}");
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

                    // Establecer el contenido de la fila de totales asegurando que los campos no necesarios estén vacíos
                    $sheet->setCellValue("A{$totalRow}", 'Minutos totales para "' . $clientJobs->first()->clientname . '"');
                    $sheet->setCellValue("F{$totalRow}", $clientJobs->sum('totalmin') . ' min (' . number_format($clientJobs->sum('totalmin') / 60, 2) . ' horas)');

                    // Asegurarse de que otras columnas queden vacías
                    $sheet->setCellValue("C{$totalRow}", '');
                    $sheet->setCellValue("D{$totalRow}", '');
                    $sheet->setCellValue("E{$totalRow}", '');

                    // Incrementar `currentRow` para que la siguiente fila comience después del total
                    $currentRow++;
                }

                // Calcular el total de todos los minutos de los trabajos
                $totalMinutes = $this->jobs->sum('totalmin');
                $totalHours = number_format($totalMinutes / 60, 2);

                // Fila de total de todos los trabajos
                $totalAllRow = $currentRow;

                // Fusionar todas las celdas de la fila para el total general
                $sheet->mergeCells("A{$totalAllRow}:G{$totalAllRow}");

                // Aplicar estilo negrita y alineación a la izquierda
                $sheet->getStyle("A{$totalAllRow}:G{$totalAllRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                    ],
                ]);

                // Establecer el contenido de la celda de total general
                $sheet->setCellValue("A{$totalAllRow}", "Tiempo total de todos los trabajos: {$totalMinutes} minutos ({$totalHours} horas)");
            },
        ];
    }
}





