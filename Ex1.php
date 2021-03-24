<?php
header ("Content-type: image/png");
$font = 'arial.ttf';
$min=0;
$max=9;
$freq_interval=[];
//создаем массив из 10 случайных чисел
mt_srand((double)microtime()*1000000);
for($i=0; $i<10; $i++) {
    $arr[$i] = mt_rand($min, $max);
}
//сортируем поулченный массив
sort($arr);
$n=0;
$k=0;
//складываем (count) соответственно числа, попавшие в интервалы
for($i=0; $i<5; $i++) {
    $freq_interval[$i]=0;
    $n=$n+2;
    while ($arr[$k]<$n) {
        $freq_interval[$i] = $freq_interval[$i] + 1;
        $k = $k + 1;
        if ($k==10) break 2;
    }
};
//задаем параметры для изображения
$widthImage = 700;
$heightImage = 900;
//создаем изображение, возвращая в im дескриптор
$im = ImageCreate($widthImage, $heightImage)
or die ("imageCreate error");
//цвет фона
$blanc = ImageColorAllocate ($im, 255, 255, 255);
//цвет для оформления
$noir = ImageColorAllocate ($im, 0, 0, 0);
//толщина оформления 
imagesetthickness($im,4);
//линия по-горизонтали 
ImageLine ($im, 10, $heightImage-30, $widthImage  , $heightImage-30, $noir);
$interval=0;
//пишем интервалы под диаграммой
for ($i=0; $i<=4; $i++) {
    $string='['.($interval).','.($interval+2).')';
    imagettftext ($im, 15,0, $i*120+60, $heightImage-13, $noir,$font,$string);
    $interval=$interval+2;
}
//линия по-вертикали
ImageLine ($im, 10, 10, 10, $heightImage-13, $noir);
$maxV = max($freq_interval);
//сами диаграммы
for ($i=0; $i<5; $i++) {
    $colH = $widthImage * $freq_interval[$i] / $maxV;
    $colW = $widthImage / 5;
    $x1 = $i * $colW+20;
    $y1 = $heightImage - $colH;
    $x2 = ($i + 1) * $colW ;
    $y2 =$heightImage-35;
    if ($colH) imagefilledrectangle($im, $x1, $y1, $x2, $y2, imagecolorallocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
}
//изначальный массив цифр
imagettftext ($im, 25,0, $widthImage/3, 50, $noir, $font,implode ( $arr ));
//генерация изображения
ImagePng ($im);
