Из БД приходят массивы типа

```
$arrayA = [
  [
    'id' => 8,
    'bannerName' => 'name8',
    'views' => 5,
  ],
  [
    'id' => 14,
    'bannerName' => 'name14',
    'views' => 8,
  ],
  [
    'id' => 10,
    'bannerName' => 'name10',
    'views' => 10,
  ],
];
```

```
$arrayB = [
  [
    'id' => 14,
    'clicks' => 2,
  ],
  [
    'id' => 10,
    'clicks' => 3,
  ],
];
```

Нужно их собрать в такой:

```
$result = [
  [
    'id' => 8,
    'bannerName' => 'name8',
    'views' => 5,
    'clicks' => 0,
    'ctr' => 0,
  ],
  [
    'id' => 14,
    'bannerName' => 'name14',
    'views' => 8,
    'clicks' => 2,
    'ctr' => 25,
  ],
  [
    'id' => 10,
    'bannerName' => 'name10',
    'views' => 10,
    'clicks' => 3,
    'ctr' => 30,
  ],
];
```

Логика поля `crt` подчинена следующему правилу

```
'ctr' => round(('clicks' /'views') * 100, 2)
```