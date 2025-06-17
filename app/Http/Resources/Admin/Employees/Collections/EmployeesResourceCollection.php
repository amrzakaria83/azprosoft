<?php

namespace App\Http\Resources\Admin\Employees\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\admin\Employees\EmployeesResource;
use App\Models\Employee;

class EmployeesResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this ->collection->map( fn( $employee ) => new EmployeesResource ( $employee ) );
        return [
            'data' => $data,
            'recordsFiltered' => Employee::count(),
            'recordsTotal' => Employee::count(),
            'draw' => $request->draw,
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'],$jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}
