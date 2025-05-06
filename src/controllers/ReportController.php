<?php

    namespace App\controllers;

    use App\models\Book;
    use App\core\BaseController;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use Mpdf\Mpdf;

    class ReportController extends BaseController {

        public function downloadExel(): void {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Report-bookstore.xlsx"');
            header('Cache-Control: max-age=0');

            $books = (new Book())->getAll();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $headers = ['Название', 'Автор', 'Жанры', 'Год', 'Издательство', 'ISBN', 'Кол-во страниц', 'Возраст', 'Дата поступления', 'Вес', 'Цена', 'Описание'];
            $sheet->fromArray($headers, null, 'A1');
            $sheet->getStyle('A1:L1')->getFont()->setBold(true);

            $row = 2;
            foreach ($books as $book) {
                $sheet->fromArray([
                    $book['book_name'],
                    $book['book_author'],
                    $book['genres'],
                    $book['book_year'],
                    $book['book_publisher'],
                    $book['book_isbn'],
                    $book['book_pages'],
                    $book['book_age'],
                    $book['book_release_date'],
                    $book['book_weight'],
                    $book['book_price'],
                    $book['book_summary']
                ], null, "A$row");
                $row++;
            }

            foreach (range('A', 'L') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save("php://output");
            exit();
        }

        public function downloadPdf(): void {
            $books = (new Book())->getAll();
        
            $adminName = $_SESSION['user_name'];
            $date = date('d.m.Y H:i');
        
            $html = '
            <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
                h1 { text-align: left; font-size: 20px; margin-bottom: 5px; }
                .meta { text-align: left; margin-bottom: 20px; font-size: 13px; }
                table { width: 100%; border-collapse: collapse; font-size: 10px; }
                th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
                th { background-color: #f0f0f0; font-weight: bold; }
            </style>
        
            <h1>Ведомость по книгам торговой площадки BookStore</h1>
            <div class="meta">
                Дата формирования: <strong>' . $date . '</strong><br>
                Составил: <strong>' . htmlspecialchars($adminName) . '</strong>
            </div>
        
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Автор</th>
                        <th>Жанры</th>
                        <th>Год</th>
                        <th>Издательство</th>
                        <th>ISBN</th>
                        <th>Страницы</th>
                        <th>Возраст</th>
                        <th>Дата поступления</th>
                        <th>Вес (г)</th>
                        <th>Цена (Р)</th>
                        <th>Описание</th>
                    </tr>
                </thead>
                <tbody>';
        
            foreach ($books as $book) {
                $html .= '
                    <tr>
                        <td>' . htmlspecialchars($book['book_name']) . '</td>
                        <td>' . htmlspecialchars($book['book_author']) . '</td>
                        <td>' . htmlspecialchars($book['genres']) . '</td>
                        <td>' . htmlspecialchars($book['book_year']) . '</td>
                        <td>' . htmlspecialchars($book['book_publisher']) . '</td>
                        <td>' . htmlspecialchars($book['book_isbn']) . '</td>
                        <td>' . htmlspecialchars($book['book_pages']) . '</td>
                        <td>' . htmlspecialchars($book['book_age']) . '</td>
                        <td>' . htmlspecialchars($book['book_release_date']) . '</td>
                        <td>' . htmlspecialchars($book['book_weight']) . '</td>
                        <td>' . htmlspecialchars($book['book_price']) . '</td>
                        <td>' . htmlspecialchars($book['book_summary']) . '</td>
                    </tr>';
            }
        
            $html .= '
                </tbody>
            </table>';
        
            $mpdf = new Mpdf([
                'format' => 'A4-L',
                'tempDir' => '/tmp/mpdf',
            ]);
        
            $mpdf->SetTitle('Ведомость по книгам');
            $mpdf->WriteHTML($html);
            $mpdf->SetFooter('{PAGENO} / {nbpg}');
        
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="Report-bookstore.pdf"');
            echo $mpdf->Output('', 'S');
            exit();
        }        

    }

?>