<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table class="table table-bordered">
        <thead>
          <tr style="height: 10px;">
            <th colspan="8" class="bg-success" ><p style="text-align:center; font-size:20px;">Memorization of the Holy Quran</p></th>
          </tr>
        </thead>
        <tbody>
            <th>Nama Siswa</th>
            <th>{{$siswa->no_induk}}</th>
            <th>{{$nilai->predikat}}</th>
            {{-- <th>{{$indikatorTahfiz->indikator}}</th> --}}
          <tr class="bg-success" style="height: 40px; font-size:15px;">
            <th ><p style="text-align:center;">Weak</p></th>
            <th ><p style="text-align:center;">Acceptable</p></th>
            <th ><p style="text-align:center;">Good</p></th>
            <th ><p style="text-align:center;">Very Good</p></th>
            <th ><p style="text-align:center;">Excellent</p></th>
            <th ><p style="text-align:center;">Capabilities</p></th>
            <th width="40px"><p class="text-align:center;">Term</p></th>
            <th width="40px"><p class="text-algin:center;">Year</p></th>
          </tr>
          
          <tr class="bg-success" >
            <th style="font-size:10px" width="65px">NI</th>
            <th style="font-size:10px" width="65px">P</th>
            <th style="font-size:10px" width="65px">C</th>
            <th style="font-size:10px" width="65px">D</th>
            <th style="font-size:10px" width="65px">HD</th>
            <th style="font-size:10px">Abilities</th>
            <th></th>
            <th></th>
          </tr>
          
          <tr style="height: 50px; font-size:15px;" >
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            
            <th><span class="check">&#10003</span></th>
           
            <th>Al-Baqarah - An-Nisa</th>
           
            <th rowspan="4"><p class="text-align:center;">3</p></th>
            <th rowspan="4"><p class="text-align:center;">7</p></th>
          </tr>
      
          <tr style="height: 50px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th></th>
            <th>Al-Mulk - Nuh</th>
            
            
          </tr>
          <tr style="height: 50px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th>Al Ikhlas - Ad-Dhuha</th>
            
            
          </tr>
          <tr style="height: 50px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th>Al-Ikhlas - An-Nass</th>
           
            
          </tr>
          {{-- <tr style="height: 50px; font-size:15px;">
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
           
            
          </tr> --}}
        </tbody>
      </table>
      
      <table class="table table-bordered">
        <tbody>
          <tr class="bg-success" style="height: 40px; font-size:15px;" width="100px;">
            <th ><p style="text-align:center;">Weak</p></th>
            <th ><p style="text-align:center;">Acceptable</p></th>
            <th ><p style="text-align:center;">Good</p></th>
            <th ><p style="text-align:center;">Very Good</p></th>
            <th ><p style="text-align:center;">Excellent</p></th>
            <th ><p style="text-align:center;">Behavior and enthusiasm</p></th>
          </tr>
          <tr class="bg-success" >
            <th style="font-size:10px" width="75px">NI</th>
            <th style="font-size:10px" width="75px">P</th>
            <th style="font-size:10px" width="75px">C</th>
            <th style="font-size:10px" width="75px">D</th>
            <th style="font-size:10px" width="75px">HD</th>
            <th style="font-size:10px">Tahfiz Habits</th>
          </tr>
          <tr style="height: 55px; font-size:15px;" >
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th>
            
              <p style="text-align:left;">Able to read Al Quran with tartil</p>
            </th>
            
          </tr>
          <tr style="height: 55px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th></th>
            <th>
             
              <p style="text-align:left;">Able to listen to the teachers reading</p>
            </th>
          </tr>
          <tr style="height: 55px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th></th>
            <th>
             
              <p style="text-align:left;">Able to repeat the teachers tahfizh pronunciation</p>
            </th>
            
            
          </tr>
          <tr style="height: 55px; font-size:15px;">
            <th ></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span class="check">&#10003</span></th>
            <th>
            
              <p style="text-align:left;">Able to memorize Al-Quran fluently</p>
            </th>
            
            
          </tr>
       
        </tbody>
      </table>
</body>
</html>



<style>
    .span {
    content: "\2700";
}
    .check { font-family: DejaVu Sans; }
    .arab {
    font-family: "DejaVu Sans Mono", monospace;
    }
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