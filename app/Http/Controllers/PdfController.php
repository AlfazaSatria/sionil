<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PdfController extends Controller
{
    public function PDFTahfiz()
    {
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml(
        '
<style>
.table-bordered {
    border: 1px solid #0A0B0B;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
thead {
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
}

tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}

tbody {
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}

tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}

.table-bordered th {
    border: 1px solid #dee2e6;
}

.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    
}

.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    
}

.bg-success {
    background-color: #8FFFC2!important;
}

</style>

	<table class="table table-bordered">
  <thead>
    <tr style="height: 10px;">
      <th colspan="8" class="bg-success" ><p style="text-align:center; font-size:20px;">تحفيظ القرآن الكريم</p></th>
      
    </tr>
  </thead>
  <tbody>
    <tr class="bg-success" style="height: 40px; font-size:15px;">
      <th ><p style="text-align:center;">ضعيف</p></th>
      <th ><p style="text-align:center;"> مقبول</p></th>
      <th><p style="text-align:center;">ج ّيد</p></th>
      <th ><p style="text-align:center;">ج ّيد ج ّدا</p></th>
      <th><p style="text-align:center;">ممتاز</p></th>
      <th><p style="text-align:center;">قدرات</p></th>
      <th><p style="text-align:center;">الفصل</p></th>
      <th><p style="text-align:center;">ال ّسنة</p></th>
    </tr>
    <tr class="bg-success" >
      <th style="font-size:10px" width="70px">NI</th>
      <th style="font-size:10px" width="70px">P</th>
      <th style="font-size:10px" width="70px">C</th>
      <th style="font-size:10px" width="70px">D</th>
      <th style="font-size:10px" width="70px">HD</th>
      <th style="font-size:10px">Abilities</th>
      <th style="font-size:10px;" width="40px">Term</th>
      <th style="font-size:10px;" width="40px">Year</th>
    </tr>
    <tr style="height: 50px; font-size:15px;" >
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th rowspan="7"><p class="text-align:center;">3</p></th>
      <th rowspan="7"><p class="text-align:center;">7</p></th>
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      
     
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
     
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
     
      
    </tr>
  </tbody>
</table>

<table class="table table-bordered">
  <tbody>
    <tr class="bg-success" style="height: 40px; font-size:15px;">
      <th ><p style="text-align:center;">ضعيف</p></th>
      <th ><p style="text-align:center;"> مقبول</p></th>
      <th><p style="text-align:center;">ج ّيد</p></th>
      <th ><p style="text-align:center;">ج ّيد ج ّدا</p></th>
      <th><p style="text-align:center;">ممتاز</p></th>
      <th><p style="text-align:center;">السلوك والحماسة</p></th>
    </tr>
    <tr class="bg-success" >
      <th style="font-size:10px" width="70px">NI</th>
      <th style="font-size:10px" width="70px">P</th>
      <th style="font-size:10px" width="70px">C</th>
      <th style="font-size:10px" width="70px">D</th>
      <th style="font-size:10px" width="70px">HD</th>
      <th style="font-size:10px">Tahfiz Habits</th>
    </tr>
    <tr style="height: 50px; font-size:15px;" >
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>
        <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
        </p>
        <p style="text-align:left;">Able to read Al Quran with tartil</p>
      </th>
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>
        <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
        </p>
        <p style="text-align:left;">Able to listen to the teachers reading</p>
      </th>
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>
        <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
        </p>
        <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
      </th>
      
      
    </tr>
    <tr style="height: 50px; font-size:15px;">
      <th ></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>
        <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
        </p>
        <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
      </th>
      
      
    </tr>
 
  </tbody>
</table>

        '

        );
        $dompdf->render();


        $dompdf->stream("RaportTahfiz_SMPMumtaza");
    }
}
