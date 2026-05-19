<?php

declare (strict_types=1);

class IdNaoEncontratoException extends InvalidArgumentException {

    public function __construct(){
        parent::__construct("Erro: valor para ID inválido ou inexistente.");
    }

}
