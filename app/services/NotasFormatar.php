<?php

namespace App\Services;

class NotasFormatar {
    public function formataNotasPeriodos($notas, $criterio_avaliativo)
    {
        if (!empty($notas) && !empty($criterio_avaliativo)) {
            foreach ($notas as $nota) {
                $nota->valor_nota = $this->arredondaNota($nota->valor_nota, $criterio_avaliativo->arredondamento_id);
            }
        }

        return $notas;
    }

    public function calculaNotaFinal($notas, $disciplinas, $criterio_avaliativo)
    {
        if (!empty($notas) && !empty($disciplinas) && !empty($criterio_avaliativo)) {
            $soma_notas = 0;
            $contador_notas = 0;

            foreach ($disciplinas as $disciplina) {
                foreach ($notas as $nota) {
                    if ($nota->disciplina_id == $disciplina->disciplina_id) {
                        $soma_notas += $nota->valor_nota;
                        $contador_notas++;
                    }
                }
            }

            if ($contador_notas > 0) {
                // Aplicando o peso nos bimestres
                $nota_final = ($soma_notas + ($soma_notas * 2) + ($soma_notas * 2)) / 6;
                return $this->arredondamentoNotaFinal($nota_final);
            } else {
                return null;
            }
        }
    }

    protected function arredondamentoNotaFinal($nota_final)
    {
        // Arredondamento conforme o novo requisito
        $fracao_decimal = $nota_final - floor($nota_final);
        if ($fracao_decimal >= 0.7) {
            return ceil($nota_final);
        } else {
            return floor($nota_final);
        }
    }

    protected function arredondaNota($nota, $arredondamento_id)
    {
        if (!is_null($arredondamento_id) && !is_null($nota)) {
            return $this->{"arredondamento$arredondamento_id"}($nota);
        }

        return $nota;
    }

    protected function arredondamento1($valor_nota)
    {
        return ceil($valor_nota);
    }

    protected function arredondamento2($valor_nota)
    {
        return floor($valor_nota);
    }
}