<?php

namespace App\Http\Livewire;

use App\Charts\DatabaseAnalysis;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;
use Livewire\WithPagination;
use Symfony\Component\Finder\Finder;




class ChartComponent extends Component
{
    use WithPagination;
    protected $blackListedTables = [];

    public $selectedTable;

    public $selectedTableColumns;

    public $showSerialNumber = false;

    public $paginationList = [10,20,50,100,500,1000];

    public $perPage = 10;

    public function updating($name, $value)
    {
        //list of Property changes in which that
        //page number needs to be set to 
        //first page

        $resetColumnsOnChange = [
            'selectedTable',
        ];
            if(in_array($name,$resetColumnsOnChange)):
                $this->selectedTableColumns = [];
            endif;

        $resetPagination = [
            'perPage',
            'selectedTable',
        ];
            if(in_array($name,$resetPagination)):
                $this->gotoPage(1);
            endif;
        return;
    }
    
    public function getTablesListProperty()
    {
        // $this->tableColumns = [];

        $this->blackListedTables = [
            Config::get('queue.failed.table'),
            Config::get('queue.connections.database.table'),
            Config::get('database.migrations'),
        ];  

        return collect(Schema::getConnection()->getDoctrineSchemaManager()->listTableNames())
                    ->reject(function($eachTable){
                            return (in_array($eachTable,$this->blackListedTables));
                    })
                    ->values()
                    ->keyByValue()
                    ->map(function($eachTable){
                        return Str::studly($eachTable).' ('.($eachTable).')';
                    })
                    ->prepend('Choose Table Name','')
                    ->toArray();
    }

    public function getTableColumnsProperty()
    {

        if(! $this->selectedTable)
        {
            return [];
        }


        $tableColumns = Schema::getConnection()
                        ->getDoctrineSchemaManager()
                        ->listTableColumns($this->selectedTable);
        

        $r =  collect($tableColumns)
                ->keys()
                ->keyByValue()
                ->map(function($eachTable){
                    return Str::studly($eachTable).' ('.($eachTable).')';
                })
                ->toArray();
        return ($r);
    }

    public function render()
    {
        // $finder = collect((new Finder())
        //         ->in(base_path('vendor'))
        //         ->files()
        //         ->name(['*.md','*.xml','LICENSE','txt','*.sql','*.lock'])
        //         ->name('*.*')
        //         // ->name('*.lock')
        //         ->notName('*.php')
        //         ->exclude(['composer']))
        //         ->values()
        //         ->groupBy(function(\Symfony\Component\Finder\SplFileInfo $fileObject){
        //             if($fileObject->getExtension() && $fileObject->getExtension() !== ''){
        //                 return $fileObject->getExtension();
        //             }
        //             return $fileObject->getFilename();
        //         })
        //         ->dd();

                
        $tableData = null;



        if($this->selectedTableColumns && $this->selectedTable)
        {
            $tableData = DB::table($this->selectedTable)
                            ->select($this->selectedTableColumns)
                            ->paginate($this->perPage);
        }
        $sizeOfCurrentProjectDatabse = DB::table('information_schema.TABLES')
            ->select(['TABLE_NAME as TableName','table_rows as TableRows','data_length as DataLength','index_length as IndexLength'])
            ->where('information_schema.TABLES.table_schema','=',config('database.connections.'.config('database.default').'.database'))
            ->get()
            ->map(function($eachDatabse){

                $dataIndex = $eachDatabse->DataLength + $eachDatabse->IndexLength;

                $modifiedObject = new \StdClass;
                $kbSize = ($dataIndex/1024);
                $mbSize = ($kbSize/1024);
                $modifiedObject->SizeInKb = $kbSize;
                $modifiedObject->SizeInMB = $mbSize;

                return new Fluent(array_merge((array)$eachDatabse,(array)$modifiedObject));

            })
            ->keyBy('TableName');
            
            // dd($sizeOfCurrentProjectDatabse);
            $chartObject = new DatabaseAnalysis;

            $stringCallback = function($eachTable){

                $string = '';
                $string .= Str::plural('Row',$eachTable->TableRows);
                $string .= ' ('.$eachTable->TableRows.') ';
                $string .= 'Size in MB';
                $string .= ' ('.$eachTable->SizeInMB.') ';
                $string .= 'Size in KB';
                $string .= ' ('.$eachTable->SizeInKb.') ';
                return $string;
                };
            // dd($sizeOfCurrentProjectDatabse);
            $chartObject->labels($sizeOfCurrentProjectDatabse->keys()->toArray());
            
            // $chartObject->dataset('SizeInMB','bar', $sizeOfCurrentProjectDatabse->pluck('SizeInMB'));
            
            $chartObject->dataset('TableRows','bar', $sizeOfCurrentProjectDatabse->pluck('TableRows'))
                        ->color($color = RandomColor::many($sizeOfCurrentProjectDatabse->count()))
                        ->backgroundColor($bgColor = RandomColor::many($sizeOfCurrentProjectDatabse->count()));
            $chartObject->options(['scales' =>     $this->chartSetAxes('Date format(DD-MM)','Hours in (24) time format')]);

            // $chartObject->dataset('TableRows','bar', $sizeOfCurrentProjectDatabse->pluck('TableRows'))
            //             ->color($color)
            //             ->backgroundColor($bgColor);
            // $chartObject->options([
            //     'tooltips' => [
            //         function(){
            //             dd('hai');
            //         },
            //         'callbacks' => ['label' => function(){
            //             dd('hai');
            //         }]
            //         ]
            //     ]);

        
        return view('livewire.chart-component',compact('tableData','chartObject'));
    }

    function chartSetAxes($xAxes = 'Time(in 24 hrs)', $yAxes = 'No Of Tickets', $showXaxis = true, $showYaxis = true)
    {
        $axesArray = [
            'xAxes' =>
            [
                [
                    'scaleLabel' =>
                    [
                        'display' => $showXaxis,
                        'labelString' => $xAxes,
                    ],
                ]
            ],

            'yAxes' =>
            [
                [
                    'scaleLabel' =>
                    [
                        'display' => $showYaxis,
                        'labelString' => $yAxes,
                    ],
                ]
            ],


        ];

        return $axesArray;
    }
}


class RandomColor
{
  static public $dictionary = null;

  private function __construct() {}

  static public function one($options = array())
  {
    $h = self::_pickHue($options);
    $s = self::_pickSaturation($h, $options);
    $v = self::_pickBrightness($h, $s, $options);

    return self::format(compact('h','s','v'), @$options['format']);
  }

  static public function many($count, $options = array())
  {
    $colors = array();

    for ($i = 0; $i < $count; $i++)
    {
      $colors[] = self::one($options);
    }

    return $colors;
  }

  static public function format($hsv, $format='hex')
  {
    switch ($format)
    {
      case 'hsv':
        return $hsv;

      case 'hsl':
        return self::hsv2hsl($hsv);

      case 'hslCss':
        $hsl = self::hsv2hsl($hsv);
        return 'hsl(' . $hsl['h'] . ',' . $hsl['s'] . '%,' . $hsl['l'] . '%)';

      case 'rgb':
        return self::hsv2rgb($hsv);

      case 'rgbCss':
        return 'rgb(' . implode(',', self::hsv2rgb($hsv)) . ')';

      case 'hex':
      default:
        return self::hsv2hex($hsv);
    }
  }

  static private function _pickHue($options)
  {
    $range = self::_getHueRange($options);

    if (empty($range))
    {
      return 0;
    }

    $hue = self::_rand($range, $options);

    // Instead of storing red as two separate ranges,
    // we group them, using negative numbers
    if ($hue < 0)
    {
      $hue = 360 + $hue;
    }

    return $hue;
  }

  static private function _pickSaturation($h, $options)
  {
    if (@$options['hue'] === 'monochrome')
    {
      return 0;
    }
    if (@$options['luminosity'] === 'random')
    {
      return self::_rand(array(0, 100), $options);
    }

    $colorInfo = self::_getColorInfo($h);
    $range = $colorInfo['s'];

    switch (@$options['luminosity'])
    {
      case 'bright':
        $range[0] = 55;
        break;

      case 'dark':
        $range[0] = $range[1] - 10;
        break;

      case 'light':
        $range[1] = 55;
        break;
    }

    return self::_rand($range, $options);
  }

  static private function _pickBrightness($h, $s, $options)
  {
    if (@$options['luminosity'] === 'random')
    {
      $range = array(0, 100);
    }
    else
    {
      $range = array(
        self::_getMinimumBrightness($h, $s),
        100
        );

      switch (@$options['luminosity'])
      {
        case 'dark':
          $range[1] = $range[0] + 20;
          break;

        case 'light':
          $range[0] = ($range[1] + $range[0]) / 2;
          break;
      }
    }

    return self::_rand($range, $options);
  }

  static private function _getHueRange($options)
  {
    $ranges = array();

    if (isset($options['hue']))
    {
      if (!is_array($options['hue']))
      {
        $options['hue'] = array($options['hue']);
      }

      foreach ($options['hue'] as $hue)
      {
        if ($hue === 'random')
        {
          $ranges[] = array(0, 360);
        }
        else if (isset(self::$dictionary[$hue]))
        {
          $ranges[] = self::$dictionary[$hue]['h'];
        }
        else if (is_numeric($hue))
        {
          $hue = intval($hue);

          if ($hue <= 360 && $hue >= 0)
          {
            $ranges[] = array($hue, $hue);
          }
        }
      }
    }

    if (($l = count($ranges)) === 0)
    {
      return array(0, 360);
    }
    else if ($l === 1)
    {
      return $ranges[0];
    }
    else
    {
      return $ranges[self::_rand(array(0, $l-1), $options)];
    }
  }

  static private function _getMinimumBrightness($h, $s)
  {
    $colorInfo = self::_getColorInfo($h);
    $bounds = $colorInfo['bounds'];

    for ($i = 0, $l = count($bounds); $i < $l - 1; $i++)
    {
      $s1 = $bounds[$i][0];
      $v1 = $bounds[$i][1];
      $s2 = $bounds[$i+1][0];
      $v2 = $bounds[$i+1][1];

      if ($s >= $s1 && $s <= $s2)
      {
        $m = ($v2 - $v1) / ($s2 - $s1);
        $b = $v1 - $m * $s1;
        return $m * $s + $b;
      }
    }

    return 0;
  }

  static private function _getColorInfo($h)
  {
    // Maps red colors to make picking hue easier
    if ($h >= 334 && $h <= 360)
    {
      $h-= 360;
    }

    foreach (self::$dictionary as $color)
    {
      if ($color['h'] !== null && $h >= $color['h'][0] && $h <= $color['h'][1])
      {
        return $color;
      }
    }
  }

  static private function _rand($bounds, $options)
  {
    if (isset($options['prng']))
    {
      return $options['prng']($bounds[0], $bounds[1]);
    }
    else
    {
      return mt_rand($bounds[0], $bounds[1]);
    }
  }

  static public function hsv2hex($hsv)
  {
    $rgb = self::hsv2rgb($hsv);
    $hex = '#';

    foreach ($rgb as $c)
    {
      $hex.= str_pad(dechex($c), 2, '0', STR_PAD_LEFT);
    }

    return $hex;
  }

  static public function hsv2hsl($hsv)
  {
    extract($hsv);

    $s/= 100;
    $v/= 100;
    $k = (2-$s)*$v;

    return array(
      'h' => $h,
      's' => round($s*$v / ($k < 1 ? $k : 2-$k), 4) * 100,
      'l' => $k/2 * 100,
      );
  }

  static public function hsv2rgb($hsv)
  {
    extract($hsv);

    $h/= 360;
    $s/= 100;
    $v/= 100;

    $i = floor($h * 6);
    $f = $h * 6 - $i;

    $m = $v * (1 - $s);
    $n = $v * (1 - $s * $f);
    $k = $v * (1 - $s * (1 - $f));

    $r = 1;
    $g = 1;
    $b = 1;

    switch ($i)
    {
      case 0:
        list($r,$g,$b) = array($v,$k,$m);
        break;
      case 1:
        list($r,$g,$b) = array($n,$v,$m);
        break;
      case 2:
        list($r,$g,$b) = array($m,$v,$k);
        break;
      case 3:
        list($r,$g,$b) = array($m,$n,$v);
        break;
      case 4:
        list($r,$g,$b) = array($k,$m,$v);
        break;
      case 5:
      case 6:
        list($r,$g,$b) = array($v,$m,$n);
        break;
    }

    return array(
      'r' => floor($r*255),
      'g' => floor($g*255),
      'b' => floor($b*255),
      );
  }
}

/*
 * h=hueRange
 * s=saturationRange : bounds[0][0] ; bounds[-][0]
 */
RandomColor::$dictionary = array(
  'monochrome' => array(
    'bounds' => array(array(0,0), array(100,0)),
    'h' => NULL,
    's' => array(0,100)
    ),
  'red' => array(
    'bounds' => array(array(20,100),array(30,92),array(40,89),array(50,85),array(60,78),array(70,70),array(80,60),array(90,55),array(100,50)),
    'h' => array(-26,18),
    's' => array(20,100)
    ),
  'orange' => array(
    'bounds' => array(array(20,100),array(30,93),array(40,88),array(50,86),array(60,85),array(70,70),array(100,70)),
    'h' => array(19,46),
    's' => array(20,100)
    ),
  'yellow' => array(
    'bounds' => array(array(25,100),array(40,94),array(50,89),array(60,86),array(70,84),array(80,82),array(90,80),array(100,75)),
    'h' => array(47,62),
    's' => array(25,100)
    ),
  'green' => array(
    'bounds' => array(array(30,100),array(40,90),array(50,85),array(60,81),array(70,74),array(80,64),array(90,50),array(100,40)),
    'h' => array(63,178),
    's' => array(30,100)
    ),
  'blue' => array(
    'bounds' => array(array(20,100),array(30,86),array(40,80),array(50,74),array(60,60),array(70,52),array(80,44),array(90,39),array(100,35)),
    'h' => array(179,257),
    's' => array(20,100)
    ),
  'purple' => array(
    'bounds' => array(array(20,100),array(30,87),array(40,79),array(50,70),array(60,65),array(70,59),array(80,52),array(90,45),array(100,42)),
    'h' => array(258,282),
    's' => array(20,100)
    ),
  'pink' => array(
    'bounds' => array(array(20,100),array(30,90),array(40,86),array(60,84),array(80,80),array(90,75),array(100,73)),
    'h' => array(283,334),
    's' => array(20,100)
    )
  );
