<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

$name1 = 'Иванов';
$name2 = 'Иван';
$name3 = 'Иванович';

function getFullnameFromParts($surname, $name, $patronymic) {
    return $surname . ' ' . $name . ' ' . $patronymic;
}
echo "getFullnameFromParts принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел.\n";
echo "Пример: ";
echo (getFullnameFromParts($name1, $name2, $name3));
echo "\n";
echo "\n";

function getPartsFromFullname($array) {
    $split = explode(" ", $array);
    $separated = ['surname' => $split[0], 'name' => $split[1], 'patronymic' => $split[2]];
    return $separated;
}

echo "getPartsFromFullname принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronymic’.\n";
echo "Пример:\n";
print_r (getPartsFromFullname($example_persons_array[8]['fullname']));
echo "\n";

function getShortName($array) {
    $parts = getPartsFromFullname($array);
    $shortName = $parts['surname'] . " " . mb_substr($parts['name'], 0, 1) . ".";
    return $shortName;
}
echo "getShortName, принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» и возвращающую строку вида «Иван И.»\n";
echo "Пример: ";
echo (getShortName($example_persons_array[4]['fullname']));
echo "\n";
echo "\n";

function getGenderFromName($array) {
    $gender = 0;
    $parts = getPartsFromFullname($array);
    
    //Отчество
    $partP = $parts['patronymic'];
    if (mb_substr($partP, mb_strlen($partP) - 2, 2) == 'ич') {
        $gender += 1;
    }
    if (mb_substr($partP, mb_strlen($partP) - 3, 3) == 'вна') {
        $gender -= 1;
    }
    
    //Имя    
    $partN = $parts['name'];
    if ((mb_substr($partN, mb_strlen($partN) - 1, 1) == 'й') || (mb_substr($partN, mb_strlen($partN) - 1, 1) == 'н')) {
        $gender += 1;
    }
    if ((mb_substr($partN, mb_strlen($partN) - 1, 1) == 'а') || (mb_substr($partN, mb_strlen($partN) - 1, 1) == 'н')) {
        $gender -= 1;
    }
   
    //Фамилия
    $partS = $parts['surname'];
    if ((mb_substr($partS, mb_strlen($partS) - 1, 1) == 'в') || (mb_substr($partS, mb_strlen($partS) - 1, 1) == 'н')) {
        $gender += 1;
    }
    if ((mb_substr($partS, mb_strlen($partS) - 2, 2) == 'ва') || (mb_substr($partS, mb_strlen($partS) - 2, 2) == 'о')) {
        $gender -= 1;
    }

    if ($gender > 0) {
        return 'Мужской пол';
    } elseif ($gender < 0) {
        return 'Женский пол';
    } else {
        return 'Неопределенный пол';
    }
};

echo "Разработайте функцию getGenderFromName, принимающую как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»).\n";
echo "Пример: ";
echo (getGenderFromName($example_persons_array[3]['fullname']));

function getGenderDescription($array) {
    $man = 0;
    $woman = 0;
    $uncertain = 0;
    
    foreach ($array as $key => $value) {
        if (getGenderFromName($value['fullname']) == 'Мужской пол') {
            $man += 1;
        } elseif (getGenderFromName($value['fullname']) == 'Женский пол') {
            $woman += 1;
        }
    }
    
    $man = round($man/count($array)*100);
    echo "Мужской пол = $man".' %';
    echo "\n";
    $woman = round($woman/count($array)*100);
    echo "Женский пол = $woman".' %';
    echo "\n";
    echo "Не удалось определить = ".round(100-$man-$woman).' %';
    echo "\n";
}
echo "\n";
echo "\n";
echo "Напишите функцию getGenderDescription для определения полового состава аудитории.\n";
echo "Пример:\n";
getGenderDescription($example_persons_array);

function getPerfectPartner($surname, $name, $patronymic, $array) {
    $surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8");
    $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
    $patronymic = mb_convert_case($patronymic, MB_CASE_TITLE, "UTF-8");
  
    $fullName = getFullnameFromParts($surname, $name, $patronymic);
    $gender1 = getGenderFromName($fullName);
    $random = array_rand($array, 1);
    $fullName2 = $array[$random]['fullname'];
    $gender2 = getGenderFromName($fullName2);

    while ($gender2 != 'Женский пол')
    {
        $random = array_rand($array, 1);
        $fullName2 = $array[$random]['fullname'];
        $gender2 = getGenderFromName($fullName2);
    }
    echo "Пример:\n";
    echo getShortName($fullName)." + ".getShortName($fullName2)." = \n";
    $rand = round(rand(5000,10000)/100,2);
    echo "♡ Идеально на $rand % ♡";
    
}

echo "\n";
echo "Напишите функцию getPerfectPartner для определения «идеальной» пары.\n";
$testSurname = 'Иванов';
$testName = 'Иван';
$testPatronymic = 'Иванович';
getPerfectPartner($testSurname, $testName, $testPatronymic, $example_persons_array);
