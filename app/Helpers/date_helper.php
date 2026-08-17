<?php

if (! function_exists('to_datetime_local')) {
    /**
     * Converte um datetime vindo do Postgres (formato "Y-m-d H:i:s")
     * para o formato que o <input type="datetime-local"> do HTML espera
     * ("Y-m-d\TH:i"). Sem isso, os campos de data/hora da viagem aparecem
     * vazios ao abrir o formulário de edição.
     */
    function to_datetime_local(?string $datetime): string
    {
        if (empty($datetime)) {
            return '';
        }

        $timestamp = strtotime($datetime);

        if ($timestamp === false) {
            return '';
        }

        return date('Y-m-d\TH:i', $timestamp);
    }
}