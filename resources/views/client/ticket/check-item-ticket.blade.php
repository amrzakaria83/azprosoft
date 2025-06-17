<table class="table align-middle table-rounded table-row-dashed fs-6">
    <thead class="bg-light-dark pe-3">
        <tr class="border-bottom fs-6 fw-bold text-bold">
            <th class="min-w-25px p-3">م</th>
            <th class="min-w-150px pb-2">اسم المشروع</th>
            <th class="min-w-70px text-start pb-2">نوع الرد</th>
            <th class="min-w-70px text-start pb-2">الكمية</th>
            <th class="min-w-100px text-start pb-2">سعر الرد</th>
            <th class="min-w-100px text-start pb-2">الاجمالي </th>
            <th class="min-w-100px text-start p-3 d-print-none"><a href="javascript:;void(0)" class="text-danger" onclick="deleteCartall()">حذف الكل</a></th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">
        @php $totalcart = 0 ; @endphp
        @foreach ($cartreport as $a => $cart)
            @php $totalcart += $cart->qty * $cart->price_rd @endphp
            <tr>
                <td class="text-start">{{$a + 1}}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="ms-5">
                            <div class="fw-bold">{{$cart->project}}</div>
                        </div>
                    </div>
                </td>
                <td class="text-start">{{$cart->name_rd}}</td>
                <td class="text-start">{{$cart->qty}}</td>
                <td class="text-start">{{$cart->price_rd}}</td>
                <td class="text-start">{{$cart->qty * $cart->price_rd}}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="5" class="fs-3 text-dark fw-bold text-end">الاجمالي</td>
            <td class="text-dark fs-3 fw-bolder text-start">{{$totalcart}}</td>
        </tr>

    </tbody>
</table>
