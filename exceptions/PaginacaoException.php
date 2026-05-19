<?php

declare (strict_types=1);

class PaginacaoException extends OutOfBoundsException {

    public function __construct(){
        parent::__construct("Erro: Valor de página inválido.");
    }

}
