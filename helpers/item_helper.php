<?php

function getItemQualityName($id = null)
{
    $map = [
        0 => 'Pobre',
        1 => 'Común',
        2 => 'Infrecuente',
        3 => 'Raro',
        4 => 'Épico',
        5 => 'Legendario',
        6 => 'Artefacto',
        7 => 'Herencia'
    ];

    if ($id === null) return $map;
    return $map[$id] ?? 'Desconocido';
}
