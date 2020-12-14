<!DOCTYPE html>
<html>

<body>
 

  <table width="100%;" style="border-collapse: collapse;font-size: 14px;">

    <tr style="padding: 0; margin: 0">
      <td colspan="6" rowspan="2"
        style="font-size:20px; background-color:#8FFFC2; border:1px solid black;border-right:none;text-align:center;padding: 4px;"
        height="40px;">
        <p><b>تحفيظ القرآن الكريم</b></p>
      </td>
    </tr>
    <tr></tr>
    <tbody>
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ضعيف</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">مقبول</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ج ّيد</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ج ّيد ج ّدا
        </th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ممتاز</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">قدرات</th>
        {{-- <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;"> الفصل</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ال ّسنة</th> --}}
      </tr>
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          NI</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          P</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          C</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          D</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          HD</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          Abilities</th>
        {{-- <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          Term</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">
          Year</th> --}}
      </tr>
  
      @foreach ($nilais as $nilai)
        <?php
          $predikat= $nilai->predikat;
          $indikator = $nilai->indikator;
        ?>

      @if($predikat== 'hd')
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">✔</th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">{{$nilai->indikator}}</th>
        {{-- <th rowspan="{{$nilais->count()}}" style="border: 1px solid black; padding: 0; margin: 0;">3</th>
        <th rowspan="{{$nilais->count()}}" style="border: 1px solid black; padding: 0; margin: 0;">7</th> --}}
      </tr>
      @elseif($predikat=='d')
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">✔</th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">{{$nilai->indikator}}</th>
       
      </tr>
      @elseif($predikat=='c')
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">✔</th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">{{$nilai->indikator}}</th>
        
      </tr>
      @elseif($predikat=='p')
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">✔</th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">{{$nilai->indikator}}</th>
        
      </tr>
      @else
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">✔</th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;"></th>
        <th style="text-align:center; border: 1px solid black; padding: 0; margin: 0;">{{$nilai->indikator}}</th>
        
      </tr>
      @endif
      @endforeach
    

    </tbody>
  </table>

  <br> <br>
  <table width="100%;" style="border-collapse: collapse;font-size: 14px;">
    <tbody>
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ضعيف</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">مقبول</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ج ّيد</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ج ّيد ج ّدا
        </th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">ممتاز</th>
        <th style="text-align:center; border: 1px solid black; background-color:#8FFFC2; font-size:15px;">السلوك والحماسة</th>
      </tr >
      <tr style="border: 1px solid black; padding: 0; margin: 0;">
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          NI</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          P</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          C</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          D</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          HD</th>
        <th
          style="text-align:center; font-size:10px; border: 1px solid black; background-color:#8FFFC2; font-size:10px;">
          TAHFIZH HABITS</th>
        
          <?php
          $membaca = $nilaiRapot->membaca;
          $mendengar = $nilaiRapot->mendengarkan;
          $mengikuti = $nilaiRapot->mengikuti;
          $menghafal = $nilaiRapot->menghafal;
        ?>

        {{-- Membaca --}}
      <tr style="border: 1px solid black; padding: 0; margin: 0;" >
        @if($membaca>90)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
          </p>
          <p style="text-align:left;">Able to read Al Quran with tartil</p>
        </th>
        @elseif($membaca>80)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
          </p>
          <p style="text-align:left;">Able to read Al Quran with tartil</p>
        </th>
        @elseif($membaca>70)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black; ">
          <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
          </p>
          <p style="text-align:left;">Able to read Al Quran with tartil</p>
        </th>
        @elseif($membaca>60)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
          </p>
          <p style="text-align:left;">Able to read Al Quran with tartil</p>
        </th>
        @else
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="  border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على قراءة القرآن ترتيلا
          </p>
          <p style="text-align:left;">Able to read Al Quran with tartil</p>
        </th>
        @endif
      </tr>
      
      {{-- Mendengar --}}
      <tr style="border: 1px solid black; padding: 0; margin: 0;" >
        @if($mendengar>90)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
          </p>
          <p style="text-align:left;">Able to listen to the teachers reading</p>
        </th>
        @elseif($mendengar>80)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
          </p>
          <p style="text-align:left;">Able to listen to the teachers reading</p>
        </th>
        @elseif($mendengar>70)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black; ">
          <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
          </p>
          <p style="text-align:left;">Able to listen to the teachers reading</p>
        </th>
        @elseif($mendengar>60)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
          </p>
          <p style="text-align:left;">Able to listen to the teachers reading</p>
        </th>
        @else
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="  border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على استماع قراءة المد ّرس / المد ّرسة
          </p>
          <p style="text-align:left;">Able to listen to the teachers reading</p>
        </th>
        @endif
      </tr>

      {{-- Mengikuti --}}
      <tr style="border: 1px solid black; padding: 0; margin: 0;" >
        @if($mengikuti>90)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
          </p>
          <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
        </th>
        @elseif($mengikuti>80)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
          </p>
          <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
        </th>
        @elseif($mengikuti>70)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black; ">
          <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
          </p>
          <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
        </th>
        @elseif($mengikuti>60)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
          </p>
          <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
        </th>
        @else
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="  border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على الاتباع بعد قراءة المد ّرس / المد ّرس
          </p>
          <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
        </th>
        @endif
      </tr>

      {{-- Menghafal --}}
      <tr style="border: 1px solid black; padding: 0; margin: 0;" >
        @if($menghafal>90)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
          </p>
          <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
        </th>
        @elseif($menghafal>80)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
          </p>
          <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
        </th>
        @elseif($menghafal>70)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black; ">
          <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
          </p>
          <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
        </th>
        @elseif($menghafal>60)
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style=" border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
          </p>
          <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
        </th>
        @else
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;">✔</th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="text-align:center; font-size:10px; border: 1px solid black;  font-size:15px;"></th>
        <th style="  border: 1px solid black;  ">
          <p style="text-align:right;">القدرة على حفظ القرآن وضبطه
          </p>
          <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
        </th>
        @endif
      </tr>
   
    </tbody>
  </table>
  

</body>

</html>