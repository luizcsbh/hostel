<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {
    /**
     * Instância do modelo Eloquent.
     *
     * @var Model
     */
    protected $model;

    /**
     * Construtor da classe.
     *
     * Inicializa a classe com uma instância de um modelo Eloquent.
     *
     * @param Model $model O modelo Eloquent a ser manipulado.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Seleciona os atributos de registros relacionados para carregar junto com o modelo principal.
     *
     * Este método permite especificar quais relações e atributos dos registros relacionados
     * devem ser carregados ao realizar a consulta.
     *
     * @param array|string $atributos Uma string ou um array contendo os nomes das relações 
     *                                e/ou atributos específicos a serem carregados.
     * @return void
     */
    public function selectAtributosRegistrosRelacionados($atributos)
    {
        $this->model = $this->model->with($atributos);
    }

    /**
     * Aplica filtros à consulta com base em condições fornecidas.
     *
     * Este método permite adicionar condições de filtro à consulta, onde cada condição 
     * deve ser especificada no formato `campo:operador:valor`, separadas por ponto e vírgula.
     *
     * @param string $filtros Uma string contendo as condições de filtro separadas por ponto e vírgula.
     * @return void
     */
    public function filtro($filtros)
    {
        $filtros = explode(';',$filtros);

        foreach($filtros as $key=>$condicao) {
            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0],$c[1],$c[2]);
        }   
    }

    /**
     * Seleciona os atributos específicos a serem retornados na consulta.
     *
     * Este método permite especificar quais atributos do modelo principal devem ser 
     * incluídos na consulta, utilizando uma string de seleção bruta.
     *
     * @param string $atributos Uma string contendo os atributos a serem selecionados.
     * @return void
     */
    public function selectAtributos($atributos)
    {
        $this->model = $this->model->selectRaw($atributos);
    }

    /**
     * Executa a consulta e retorna os resultados.
     *
     * Este método finaliza a construção da consulta e retorna os resultados como uma 
     * coleção de instâncias do modelo.
     *
     * @return \Illuminate\Database\Eloquent\Collection Uma coleção de instâncias do modelo resultantes da consulta.
     */
    public function getResultado()
    {
        return $this->model->get();
    }

    public function getResultadoPaginado($numeroRegistroPorPagina)
    {
        return $this->model->paginate($numeroRegistroPorPagina);
    }

}

?>