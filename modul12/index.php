<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практическая работа модуля №12</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all">
</head>
<body>
    <?php $example_persons_array = [
        [ 'fullname'=> 'Иванов Иван Иванович',
        'job' => 'tester <br><hr>',
        ],
        [ 'fullname'=> 'Степанова Наталья Степановна',
        'job' => 'frontend-developer <br><hr>',
        ],
        [ 'fullname'=> 'Пащенко Владимир Александрович',
        'job' => 'analyst <br><hr>',
        ],
        [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer <br><hr>',
        ],
        [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst <br><hr>',
        ],
        [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer <br><hr>',
        ],
        [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager <br><hr>',
        ],
        [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager <br><hr>',
        ],
        [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst <br><hr>',
        ],
        [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer <br><hr>',
        ],
        [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter <br>',
        ]
        ];

// " Разбивание и объединение ФИО"
       
        function getFullnameFromParts($surname, $name, $patronymic)
        {
          return $surname ."\x20" . $name . "\x20" . $patronymic;
        }


        function getPartsFromFullname($fullName)
        {
        $partName = [];
        $startNum = 0;
        $strLen = mb_strlen($fullName);

        for ($a = 0; $a < $strLen; $a++) {
            
             if (mb_ord(mb_substr($fullName, $a, 1))==32) {
     
                array_key_exists('surname', $partName) ? $partName['name']=mb_substr($fullName, $startNum,    $a - $startNum) : $partName['surname']=mb_substr($fullName, $startNum, $a - $startNum);
                $startNum=$a + 1; }
       
             if ($a==$strLen - 1 && $startNum> 0) {
         
            array_key_exists('name', $partName) ? $partName['patronymic'] = mb_substr($fullName, $startNum) : $partName['Name'] = mb_substr($fullName, $startNum);
            }
            }
            return $partName;
            }

// "Сокращение ФИО"
            function getShortName($fullName)
            {
            $nameParts = getPartsFromFullname($fullName);
            return $nameParts['surname'] . "\x20" . mb_substr($nameParts['name'], 0, 1) . ".";
            }
            function getGenderFromName($fullName)
            {
            $nameParts = getPartsFromFullname($fullName);
            $man = 0;
            $wooman = 0;
            if (mb_substr($nameParts['surname'], -1) == 'в')
            $male += 1;
            elseif (mb_substr($nameParts['surname'], -2) == 'ва')
            $wooman += 1;
        
            if (mb_substr($nameParts['name'], -1) == 'й' || mb_substr($nameParts['name'], -1) == 'н')
            $man += 1;
            elseif (mb_substr($nameParts['name'], -1) == 'а')
         
            $wooman += 1;
            if (mb_substr($nameParts['patronymic'], -2) == 'ич')
           
            $man += 1;
            elseif (mb_substr($nameParts['patronymic'], -3) == 'вна')
           
            $wooman += 1;
            return $man <=> $wooman;
                }

  //'Определение возрастно-полового состава'
                function getGenderDescription($auditory)
                {
                $results;
                $maleResult = 0;
                $femaleResult = 0;
                $undefinedResult = 0;
                foreach ($auditory as $person) {
                $results[] = getGenderFromName($person['fullname']);
                }
                echo "Мужчины - " . round(count(array_filter($results, function ($num) {
                if ($num == 1)
                return true;
                else
                return false;
                })) / count($results), 2) . '%' . '<br>';
                ;
            
                echo "Женщины - " . round(count(array_filter($results, function ($num) {
                if ($num == -1)
                return true;
                else
                return false;
                })) / count($results), 2) . '%' . '<br>';
                ;
                echo "Неудалось определить - " . round(count(array_filter($results, function ($num) {
                if ($num == 0)
                return true;
                else
                return false;
                })) / count($results), 2) . '%' . '<br>';
                ;
                }

//'идеальный подброр пары'
                 
                function getPerfectPartner($surname, $name, $patronymic, $auditory)
                {
                $normalisedName = getFullnameFromParts(mb_convert_case($surname, MB_CASE_TITLE), mb_convert_case($name,    MB_CASE_TITLE), mb_convert_case($patronymic, MB_CASE_TITLE));
                $curGender = getGenderFromName($normalisedName);
                $pairPerson = null;
                do {
                $pairPerson = $auditory[rand(0, count($auditory) - 1)];
                if (getGenderFromName($pairPerson['fullname']) == $curGender)
                $pairPerson = null;
                } while ($pairPerson == null);
                echo getShortName($normalisedName) . '+' . getShortName($pairPerson['fullname']) . '=' . '<br>';
                echo "♡ Идеально на " . rand(50, 100) . "% ♡" . '<br>';
                ;
                }
                 
//Подключение стилей
                echo '<div style="font-size:40px; font-weight:bolt; color:red">Исходный
                    массив:'.'</div>';
                echo '<br>';
                print_r($example_persons_array);
                echo '<br>
                <hr>';
                $fullName = $example_persons_array[0]['fullname'];
                echo '<br>';
                echo '<div style="font-size:20px; color:green">Исходное полное имя:'.'</div> <br>' . $fullName . '<br>';
                echo '<br>
                <hr>';
                $chunckedName = getPartsFromFullname($example_persons_array[0]['fullname']);
                echo '<br>';
                echo '<div style="font-size:20px; color:silver">Результат работы  функции getPartsFromFullname:'.'</div><br>';
                print_r($chunckedName);
                echo '<br>';
                echo '<br>
                <hr>';
                echo '<br>';
                echo '<div style="font-size:20px; color:pink ">Результат работы  функции getPartsFromFullname:'.'</div><br>' .
                getFullnameFromParts($chunckedName['surname'],
                $chunckedName['name'], $chunckedName['patronymic']) . '<br>';
                echo '<br>
                <hr>';
                echo '<br>';
                echo '<div style="font-size:20px; color:orange">Результат работы  функции getShortName:'.'</div><br>' . getShortName($fullName) .
                '<br>';
                echo '<br>';
                echo '<br>
                <hr>';
                echo '<div style="font-size:20px; color:brown">Результат работы функции getGenderFromName:'.'</div><br>' .
                getGenderFromName($fullName) . '<br>';
                echo '<br>';
                echo '<br>
                <hr>';
                echo '<div style="font-size:20px; color:blue">Идеальный подбор пары: '.'</div><br>' . getShortName($fullName) . '<br>';
                getGenderDescription($example_persons_array);
                echo '<br>';
                ?>
</body>
</html
