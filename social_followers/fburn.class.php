<?php
class fbcount_h7 {

  public $im;
  public $binaryMartix;
  public $assocNumber = array(
    '32' => "*",
    '36' => 2,
    '44' => 3,
    '52' => 4,
    '48' => 6,
    '40' => "*",
    '56' => "*",
     );
  public $resolve;


  function __construct($path) {
    $this->im = @$path;

    if (!$this->im){ 
      return false;
    }
    
    $this->binaryMartix =  $this->imageToMatrix($this->im, true);   
    $explode =  $this->explodeMatrix($this->binaryMartix);
    $this->resolve = '';
    foreach ($explode as $number) {
       $this->resolve .= $this->assocNumber[$number];
    } 
  }


  function explodeMatrix($binaryMartix) {
    $temp = array();

    // сложение столбцов для выявления интервалов
    for ($i = 0; $i < count($binaryMartix); $i++) {
      $sum = 0;
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        $sum += $binaryMartix[$i][$j];
      }
      $temp[] = $sum ? 1 : 0;
    }

    // вычисление интервалов по полученной строке
    $start = false;
    $countPart = 0;
    $arrayInterval = array();
    foreach ($temp as $k => $v) {

      if ($v == 1 && !$start) {
        $arrayInterval[$countPart]['start'] = $k;
        $start = true;
      }

      if ($v == 0 && $start) {
        $arrayInterval[$countPart]['end'] = $k - 1;
        $start = false;
        $countPart++;
      }
    }

    // сложение всех единиц в полученных интервалах столбцов
    foreach ($arrayInterval as $interval) {
      $sum = 0;
      for ($i = 0; $i < count($binaryMartix); $i++) {
        for ($j = 0; $j < count($binaryMartix[0]); $j++) {
          if ($i >= $interval['start'] && $i <= $interval['end']) {
            $sum += $binaryMartix[$i][$j];
          }
        }
      }
      $result[] = $sum;
    }

    return $result;
  }

  /**
   * Конвертация рисунка в бинарную матрицу
   * Все пиксели отличные от фона получают значение 1
   * @param imagecreatefrompng $im - картинка в формате PNG
   * @param bool $rotate - горизонтальная или вертикальная матрица 
   */
  function imageToMatrix($im, $rotate = false) {
    $height = imagesy($im);
    $width = imagesx($im);

    if ($rotate) {
      $height = imagesx($im);
      $width = imagesy($im);
    }

    $background = 0;
    for ($i = 0; $i < $height; $i++)
      for ($j = 0; $j < $width; $j++) {

        if ($rotate) {
          $rgb = imagecolorat($im, $i, $j);
        } else {
          $rgb = imagecolorat($im, $j, $i);
        }

        //получаем индексы цвета RGB 
        list($r, $g, $b) = array_values(imageColorsForIndex($im, $rgb));

        //вычисляем индекс красного, для фона изображения
        if ($i == 0 && $j == 0) {
          $background = $r;
        }

        // если цвет пикселя не равен фоновому заполняем матрицу единицей
        $binary[$i][$j] = ($r == $background) ? 0 : 1;
      }
    return $binary;
  }

  /**
   * Выводит матрицу на экран
   * @param type $binaryMartix
   */
  function printMatrix($binaryMartix) {
    for ($i = 0; $i < count($binaryMartix); $i++) {
      echo "<br/>";
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        echo $binaryMartix[$i][$j]." ";
      }
    }
  }

}

class fbcount_h5 {

  public $im;
  public $binaryMartix;
  public $assocNumber = array(
    '36' => 0,
    '24' => 1,
    '28' => 2,
    '32' => 3,
    '28' => 4,
        '44' => 5,
    '28' => 6,
    '32' => 7,
        '40' => 8,
  );
  public $resolve;


  function __construct($path) {
    $this->im = @$path;

    if (!$this->im){ 
      return false;
    }
    
    $this->binaryMartix =  $this->imageToMatrix($this->im, true);   
    $explode =  $this->explodeMatrix($this->binaryMartix);
    $this->resolve = '';
    foreach ($explode as $number) {
       $this->resolve .= $this->assocNumber[$number];
    } 
  }


  function explodeMatrix($binaryMartix) {
    $temp = array();

    // сложение столбцов для выявления интервалов
    for ($i = 0; $i < count($binaryMartix); $i++) {
      $sum = 0;
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        $sum += $binaryMartix[$i][$j];
      }
      $temp[] = $sum ? 1 : 0;
    }

    // вычисление интервалов по полученной строке
    $start = false;
    $countPart = 0;
    $arrayInterval = array();
    foreach ($temp as $k => $v) {

      if ($v == 1 && !$start) {
        $arrayInterval[$countPart]['start'] = $k;
        $start = true;
      }

      if ($v == 0 && $start) {
        $arrayInterval[$countPart]['end'] = $k - 1;
        $start = false;
        $countPart++;
      }
    }

    // сложение всех единиц в полученных интервалах столбцов
    foreach ($arrayInterval as $interval) {
      $sum = 0;
      for ($i = 0; $i < count($binaryMartix); $i++) {
        for ($j = 0; $j < count($binaryMartix[0]); $j++) {
          if ($i >= $interval['start'] && $i <= $interval['end']) {
            $sum += $binaryMartix[$i][$j];
          }
        }
      }
      $result[] = $sum;
    }

    return $result;
  }

  /**
   * Конвертация рисунка в бинарную матрицу
   * Все пиксели отличные от фона получают значение 1
   * @param imagecreatefrompng $im - картинка в формате PNG
   * @param bool $rotate - горизонтальная или вертикальная матрица 
   */
  function imageToMatrix($im, $rotate = false) {
    $height = imagesy($im);
    $width = imagesx($im);

    if ($rotate) {
      $height = imagesx($im);
      $width = imagesy($im);
    }

    $background = 0;
    for ($i = 0; $i < $height; $i++)
      for ($j = 0; $j < $width; $j++) {

        if ($rotate) {
          $rgb = imagecolorat($im, $i, $j);
        } else {
          $rgb = imagecolorat($im, $j, $i);
        }

        //получаем индексы цвета RGB 
        list($r, $g, $b) = array_values(imageColorsForIndex($im, $rgb));

        //вычисляем индекс красного, для фона изображения
        if ($i == 0 && $j == 0) {
          $background = $r;
        }

        // если цвет пикселя не равен фоновому заполняем матрицу единицей
        $binary[$i][$j] = ($r == $background) ? 0 : 1;
      }
    return $binary;
  }

  /**
   * Выводит матрицу на экран
   * @param type $binaryMartix
   */
  function printMatrix($binaryMartix) {
    for ($i = 0; $i < count($binaryMartix); $i++) {
      echo "<br/>";
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        echo $binaryMartix[$i][$j]." ";
      }
    }
  }

}

class fbcount_norm {

  public $im;
  public $binaryMartix;
  public $assocNumber = array(
            '64' => 0,
            '52' => 1,
            '56' => "*",
            '56' => "*",
            '56' => "*",
            '68' => "*",
            '60' => "*",
            '44' => 7,
            '68' => "*",
            '60' => "*",
  );
  public $resolve;


  function __construct($path) {
    $this->im = @$path;

    if (!$this->im){ 
      return false;
    }
    
    $this->binaryMartix =  $this->imageToMatrix($this->im, true);   
    $explode =  $this->explodeMatrix($this->binaryMartix);
    $this->resolve = '';
    foreach ($explode as $number) {
       $this->resolve .= $this->assocNumber[$number];
    } 
  }


  function explodeMatrix($binaryMartix) {
    $temp = array();

    // сложение столбцов для выявления интервалов
    for ($i = 0; $i < count($binaryMartix); $i++) {
      $sum = 0;
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        $sum += $binaryMartix[$i][$j];
      }
      $temp[] = $sum ? 1 : 0;
    }

    // вычисление интервалов по полученной строке
    $start = false;
    $countPart = 0;
    $arrayInterval = array();
    foreach ($temp as $k => $v) {

      if ($v == 1 && !$start) {
        $arrayInterval[$countPart]['start'] = $k;
        $start = true;
      }

      if ($v == 0 && $start) {
        $arrayInterval[$countPart]['end'] = $k - 1;
        $start = false;
        $countPart++;
      }
    }

    // сложение всех единиц в полученных интервалах столбцов
    foreach ($arrayInterval as $interval) {
      $sum = 0;
      for ($i = 0; $i < count($binaryMartix); $i++) {
        for ($j = 0; $j < count($binaryMartix[0]); $j++) {
          if ($i >= $interval['start'] && $i <= $interval['end']) {
            $sum += $binaryMartix[$i][$j];
          }
        }
      }
      $result[] = $sum;
    }

    return $result;
  }

  /**
   * Конвертация рисунка в бинарную матрицу
   * Все пиксели отличные от фона получают значение 1
   * @param imagecreatefrompng $im - картинка в формате PNG
   * @param bool $rotate - горизонтальная или вертикальная матрица 
   */
  function imageToMatrix($im, $rotate = false) {
    $height = imagesy($im);
    $width = imagesx($im);

    if ($rotate) {
      $height = imagesx($im);
      $width = imagesy($im);
    }

    $background = 0;
    for ($i = 0; $i < $height; $i++)
      for ($j = 0; $j < $width; $j++) {

        if ($rotate) {
          $rgb = imagecolorat($im, $i, $j);
        } else {
          $rgb = imagecolorat($im, $j, $i);
        }

        //получаем индексы цвета RGB 
        list($r, $g, $b) = array_values(imageColorsForIndex($im, $rgb));

        //вычисляем индекс красного, для фона изображения
        if ($i == 0 && $j == 0) {
          $background = $r;
        }

        // если цвет пикселя не равен фоновому заполняем матрицу единицей
        $binary[$i][$j] = ($r == $background) ? 0 : 1;
      }
    return $binary;
  }

  /**
   * Выводит матрицу на экран
   * @param type $binaryMartix
   */
  function printMatrix($binaryMartix) {
    for ($i = 0; $i < count($binaryMartix); $i++) {
      echo "<br/>";
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        echo $binaryMartix[$i][$j]." ";
      }
    }
  }

}

class fbcount_num59 {

  public $im;
  public $binaryMartix;
  public $assocNumber = array(
            '64' => "*",
            '52' => "*",
            '56' => "*",
            '68' => 5,
            '60' => 9,
            '44' => "*",
  );
  public $resolve;


  function __construct($path) {
    $this->im = @$path;

    if (!$this->im){ 
      return false;
    }
    
    $this->binaryMartix =  $this->imageToMatrix($this->im, true);   
    $explode =  $this->explodeMatrix($this->binaryMartix);
    $this->resolve = '';
    foreach ($explode as $number) {
       $this->resolve .= $this->assocNumber[$number];
    } 
  }


  function explodeMatrix($binaryMartix) {
    $temp = array();

    // сложение столбцов для выявления интервалов
    for ($i = 0; $i < count($binaryMartix); $i++) {
      $sum = 0;
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        $sum += $binaryMartix[$i][$j];
      }
      $temp[] = $sum ? 1 : 0;
    }

    // вычисление интервалов по полученной строке
    $start = false;
    $countPart = 0;
    $arrayInterval = array();
    foreach ($temp as $k => $v) {

      if ($v == 1 && !$start) {
        $arrayInterval[$countPart]['start'] = $k;
        $start = true;
      }

      if ($v == 0 && $start) {
        $arrayInterval[$countPart]['end'] = $k - 1;
        $start = false;
        $countPart++;
      }
    }

    // сложение всех единиц в полученных интервалах столбцов
    foreach ($arrayInterval as $interval) {
      $sum = 0;
      for ($i = 0; $i < count($binaryMartix); $i++) {
        for ($j = 0; $j < count($binaryMartix[0]); $j++) {
          if ($i >= $interval['start'] && $i <= $interval['end']) {
            $sum += $binaryMartix[$i][$j];
          }
        }
      }
      $result[] = $sum;
    }

    return $result;
  }

  /**
   * Конвертация рисунка в бинарную матрицу
   * Все пиксели отличные от фона получают значение 1
   * @param imagecreatefrompng $im - картинка в формате PNG
   * @param bool $rotate - горизонтальная или вертикальная матрица 
   */
  function imageToMatrix($im, $rotate = false) {
    $height = imagesy($im);
    $width = imagesx($im);

    if ($rotate) {
      $height = imagesx($im);
      $width = imagesy($im);
    }

    $background = 0;
    for ($i = 0; $i < $height; $i++)
      for ($j = 0; $j < $width; $j++) {

        if ($rotate) {
          $rgb = imagecolorat($im, $i, $j);
        } else {
          $rgb = imagecolorat($im, $j, $i);
        }

        //получаем индексы цвета RGB 
        list($r, $g, $b) = array_values(imageColorsForIndex($im, $rgb));

        //вычисляем индекс красного, для фона изображения
        if ($i == 0 && $j == 0) {
          $background = $r;
        }

        // если цвет пикселя не равен фоновому заполняем матрицу единицей
        $binary[$i][$j] = ($r == $background) ? 0 : 1;
      }
    return $binary;
  }

  /**
   * Выводит матрицу на экран
   * @param type $binaryMartix
   */
  function printMatrix($binaryMartix) {
    for ($i = 0; $i < count($binaryMartix); $i++) {
      echo "<br/>";
      for ($j = 0; $j < count($binaryMartix[0]); $j++) {
        echo $binaryMartix[$i][$j]." ";
      }
    }
  }

}
function get_fburn($uname) {
$src = "http://feeds.feedburner.com/~fc/".$uname."?bg=fffffc&amp;fg=000000&amp;anim=0";
$imageG = imagecreatefromstring(file_get_contents($src));
$percent = 2;
$width = 35;
$height = 9;
$newwidth = $width * $percent;
$newheight = $height * $percent;
$thumb = imagecreatetruecolor($newwidth, $newheight);
$thumb_up = imagecreatetruecolor($newwidth, $newheight);
$source = $imageG;
// изменение размера
imagecopyresized($thumb, $source, 0, 0, 5, 5, $newwidth, $newheight, $width, $height);
$height = 7;
$newwidth = $width * $percent;
$newheight = $height * $percent;
$thumb_h7 = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb_h7, $source, 0, 0, 5, 5, $newwidth, $newheight, $width, $height);
$height = 5;
$newwidth = $width * $percent;
$newheight = $height * $percent;
$thumb_h5 = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb_h5, $source, 0, 0, 5, 5, $newwidth, $newheight, $width, $height);


$encrypt = new fbcount_norm($thumb); $c_norm = (string)$encrypt->resolve;
$encrypt = new fbcount_h7($thumb_h7);  $c_h7 = (string)$encrypt->resolve;
$encrypt = new fbcount_h5($thumb_h5);  $c_h5 = (string)$encrypt->resolve;
$encrypt = new fbcount_num59($thumb);  $c_59 = (string)$encrypt->resolve;
$count = "******";
$c_norm = (string) $c_norm;
//print strlen($c_norm);
for ($i = 0; $i < strlen($c_norm); $i++) {
  //print $c_norm[$i];
  if (($c_norm[$i] == 0) or ($c_norm[$i] == 1) or ($c_norm[$i] == 7)) { $count[$i]=$c_norm[$i]; }
  if (($c_h7[$i] == 2) or ($c_h7[$i] == 3) or ($c_h7[$i] == 4) or ($c_h7[$i] == 6)) { 
    if (!$c_norm[$i]==0){ $count[$i]=$c_h7[$i]; } 
    
  }
  if (($c_h5[$i] == 5) or ($c_h5[$i] == 8)) { $count[$i]=$c_h5[$i]; }
  if ($c_59[$i] == 9) { 
    if ($c_h7[$i] <> 6){ $count[$i]=$c_59[$i]; }
    }
}
$count = substr($count, 0, strlen($c_norm));
return $count;
}

?>