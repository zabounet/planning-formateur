<?php $link = "Home" ;?>

<p>Page d'accueil du site</p>
<?php if (isset($_SESSION['admin'])) :?> 
    <p>bonjour Admin</p> 
<?php elseif(isset($_SESSION['formateur'])) :?>  
    <p>bonjour User</p> 
<?php endif;?>

<br><br><br><br>

<?php 
   // Set the start and end dates
$startDate = new DateTime('2023-01-10');
$endDate = new DateTime('2023-03-10');

// Calculate the number of days between the start and end dates
$numDays = $endDate->diff($startDate)->days + 1;

// Create the header row with the dates
$headerRow = ['Employee'];
$currentDate = clone $startDate;
for ($i = 0; $i < $numDays; $i++) {
    $headerRow[] = $currentDate->format('Y-m-d');
    $currentDate->modify('+1 day');
}

// Create the data rows with the employee names and activity dates
$dataRows = [
    ['Sandy', new DateTime('2023-02-23'), new DateTime('2023-03-02')],
    ['Veronique', new DateTime('2023-01-11'), new DateTime('2023-01-20')],
    ['Veronique', new DateTime('2023-01-09'), new DateTime('2023-01-11')],
    ['Ali', new DateTime('2023-03-01'), new DateTime('2023-03-15')],
];

require_once '../vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Create the spreadsheet
$spreadsheet = new Spreadsheet();
$worksheet = $spreadsheet->getActiveSheet();

// Set the header row
$worksheet->fromArray([$headerRow], null, 'A1');

// Set the data rows
$currentRow = 2;
$currentDate = $startDate; // initialize $currentDate to earliest start date
foreach ($dataRows as $dataRow) {
    $employeeName = $dataRow[0];
    $startDate = $dataRow[1];
    $endDate = $dataRow[2];

    $currentColumn = 2;
    for ($i = 0; $i < $numDays; $i++) {
        $cellValue = '';
        if ($currentDate >= $startDate && $currentDate <= $endDate) {
            $cellValue = 'Yes';
        } else {
            $cellValue = '';
        }
        $worksheet->setCellValueByColumnAndRow($currentColumn, $currentRow, $cellValue);
        $currentColumn++;
        $currentDate->modify('+1 day');
    }

    $worksheet->setCellValueByColumnAndRow(1, $currentRow, $employeeName);
    $currentRow++;
    $currentDate = clone $startDate;
}

// Output the spreadsheet to the browser
$writer = new Html($spreadsheet);
$html = $writer->generateSheetData();
echo '<table>' . $html . '<table>';
?>
