
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Drug_request;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

public function model(array $row)
{
    return new Drug_request([
        'prod_id' => $row[0],
        'quantity' => $row[1],
        'start_id' => $row[2],
        'to_id' => $row[3],


    ]);
}



class Drug_request implements ToModel, WithHeadingRow

        public function importdrugrequest()
{
    'prod_id' => $row[0],
    'quantity' => $row[1],
    'start_id' => $row[2],
    'to_id' => $row[3],

}
