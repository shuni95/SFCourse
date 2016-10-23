@extends('layouts.app')

@section('content')

<script src="{{ url('js/app.js') }}"></script>
<style type="text/css">
    .clickable {
        cursor: pointer;
    }
    .unidad-selected {
    }
    .semana-selected {
    }
    #unidades, #semanas {
        margin-top: 15px;
        text-align: center;
    }
    #unidades .unidad{
        margin: 0 auto;
    }
    #semanas .semana {
        margin: 0 auto;
    }
    @media(min-width:1200px) {
        #unidades .unidad {
            width: 50%;
        }
        #semanas .semana {
            width: 70%;
        }
    }
    .unidad p, .semana p {
        line-height: 40px;
        margin: 0px;
    }
    .unidad-selected p {
        display: inline-block;
        background-color:  #d6dac6;
        color: #000;
        width: 70%;
    }
    .semana-selected p {
        display: inline-block;
        background: #95d5e4;
        color: #000;
        width: 70%;
    }
    @media(min-width:768px) {
        .column:first-child {
            border-right: #fcf solid 2px;
        }
    }
    @media(min-width: 992px) {
        .column {
            border-right: #fcf solid 2px;
        }
    }
    .btn {
        border-radius: 0;
        margin-top: -2px;
    }
    .btn-danger {
        height: 40px;
    }
    .btn-danger > .glyphicon {
        top: 3px;
    }
    h1,h2,h3,h4,h5,h6 { cursor: default; }
</style>

<div class="col-lg-12" id="app">
    <div class="text-center">
        <h1>Registrar Syllabus del curso de Programacion I</h1>
    </div>
</div>

<div class="col-lg-12">

    <div class="col-sm-6 col-md-3 column">
        <div class="row">
            <div class="text-center">
                <h3>Unidades</h3>
                <a class="btn btn-success" @click="add_unidad()" title="Agregar Unidad">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="text-center">
                <div id="unidades">
                    <div class="clickable unidad"
                        id="unidad_@{{ unidad.id }}"
                        v-for="unidad in unidades"
                        @click="select_unidad(unidad)"
                    >
                        <p>@{{ unidad.name }}</p>
                        <a type="button"
                           class="btn btn-danger"
                           v-show="unidad_selected == unidad"
                           title="Eliminar"
                           @click="delete_unidad(unidad)"
                        >
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-6 col-md-3 column">
        <div class="row">
            <div class="text-center">
                <h3>Semanas</h3>
                <a class="btn btn-success" @click="add_semana()" v-show="unidad_selected.id" title="Agregar Unidad">
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="text-center">
                <h4><i>@{{ unidad_selected.name }}</i></h4>
                <div id="semanas">
                    <div class="clickable semana"
                         id="semana_@{{ semana.id }}"
                         v-for="semana in semanasUnidadSeledted(unidad_selected)"
                         @click="select_semana(semana)"
                    >
                        <p>@{{ semana.name }}</p>
                        <a type="button"
                           class="btn btn-danger"
                           v-show="semana_selected == semana"
                           title="Eliminar"
                           @click="delete_semana(semana)"
                        >
                          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="row">
            <div class="text-center">
                <h3><i>@{{ tema_title }}</i></h3>
                <div id="temas">
                    <div class="clickable tema"
                         id="tema_@{{ tema.id }}"
                         v-for="tema in semana_selected.temas"
                    >
                        <p>@{{ tema.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<script type="text/javascript">
    var vm = new Vue(
    {
        el: 'body',

        data: {
            unidades: [],
            semanas: [],
            temas: [],
            unidad_selected: {},
            semana_selected: {},
            tema_selected: {},
            last_unidad_id: 0,
            last_semana_id: 0,
            last_tema_id: 0,
            tema_title: '',
            max_unidades: 5,
            max_semanas: 17,
            max_semanas_por_unidad: 5,
        },

        methods: {
            select_unidad: function(unidad) {
                var last_unidad = document.getElementById('unidad_' + this.unidad_selected.id)
                var unidad_element = document.getElementById('unidad_' + unidad.id)

                if (this.unidad_selected.id == undefined) {
                    unidad_element.className += ' unidad-selected'
                    this.unidad_selected = unidad
                } else {
                    if (this.unidad_selected.id == unidad.id) {
                        unidad_element.className = 'clickable unidad'
                        this.unidad_selected = {}
                    } else {
                        last_unidad.className = 'clickable unidad'
                        unidad_element.className += ' unidad-selected'
                        this.unidad_selected = unidad
                    }
                }
                this.semana_selected = {}
            },
            select_semana: function(semana) {
                var last_semana = document.getElementById('semana_' + this.semana_selected.id)
                var semana_element = document.getElementById('semana_' + semana.id)

                if (this.semana_selected.id == undefined) {
                    semana_element.className += ' semana-selected'
                    this.semana_selected = semana
                } else {
                    if (this.semana_selected.id == semana.id) {
                        semana_element.className = 'clickable semana'
                        this.semana_selected = {}
                    } else {
                        last_semana.className = 'clickable semana'
                        semana_element.className += ' semana-selected'
                        this.semana_selected = semana
                    }
                }
            },
            add_unidad: function() {
                var new_id = ++this.last_unidad_id
                var len_unidades = this.unidades.length
                if (len_unidades < this.max_unidades)
                    this.unidades.push({
                        id: new_id,
                        name: 'Unidad ' + (len_unidades + 1)
                    })
                else
                    alert("Muchas unidades")
            },
            delete_unidad: function(unidad) {
                this.semanasUnidadSeledted(unidad).forEach(function(semana, index){
                    vm.delete_semana(semana)
                })
                this.unidades.forEach(function(elemento, index, array){
                    if (elemento.id == unidad.id)
                        array.splice(index, 1)
                })

                this.unidades.forEach(function(elemento, index){
                    elemento.name = 'Unidad ' + (index + 1)
                })

                this.unidad_selected = {}
            },
            add_semana: function() {
                var new_id = ++this.last_semana_id
                var len_semanas = this.semanas.length
                if (len_semanas < this.max_semanas) {
                    var unidad = this.unidad_selected
                    var len_semanas_por_unidad = this.semanas.reduce(function(total,semana){
                        return semana.unidad_id == unidad.id ? total+1 : total
                    }, 0)

                    if (len_semanas_por_unidad < this.max_semanas_por_unidad) {
                        this.semanas.push({
                            id: new_id,
                            name: 'Semana ' + (len_semanas + 1),
                            unidad_id: this.unidad_selected.id
                        })

                        var semanas = this.semanas
                        var semanas_por_unidades = []
                        this.unidades.forEach(function(unidad, i) {
                            semanas_por_unidades[i] = semanas.reduce(function(total,semana){
                                return semana.unidad_id == unidad.id ? total+1 : total
                            }, 0)
                        })

                        var start = 0
                        this.unidades.forEach(function(unidad, i){
                            var end = start + semanas_por_unidades[i]
                            for (; start < end; start++) {
                                semanas[start].unidad_id = unidad.id
                            }
                        })
                    }
                    else
                        alert("Muchas semanas en una unidad")
                }
                else
                    alert("Muchas semanas")
            },
            delete_semana: function(semana) {
                this.semanas.forEach(function(elemento, index, array){
                    if (elemento.id == semana.id)
                        array.splice(index, 1)
                })

                this.semanas.forEach(function(elemento, index){
                    elemento.name = 'Semana ' + (index + 1)
                })

                this.semana_selected = {}
            },
            semanasUnidadSeledted: function(unidad) {
                return this.semanas.filter(function(semana){
                    return semana.unidad_id == unidad.id
                })
            }
        },

        watch: {
            semana_selected: function(newValue)
            {
                if (newValue.id == undefined)
                    this.tema_title = ''
                else
                    this.tema_title = 'Temas - ' + this.unidad_selected.name + ' - ' + this.semana_selected.name
            }
        },

        ready: function()
        {
            this.unidades = [
                {
                    id: 1,
                    name: "Unidad 1",
                },
                {
                    id: 2,
                    name: "Unidad 2",
                },
            ]

            this.last_unidad_id += this.unidades.length

            var semanas = [
                {
                    id: 1,
                    name: "Semana 1",
                    unidad_id: 1,
                },
                {
                    id: 2,
                    name: "Semana 2",
                    unidad_id: 1,
                },
                {
                    id: 3,
                    name: "Semana 3",
                    unidad_id: 1,
                },
                {
                    id: 4,
                    name: "Semana 4",
                    unidad_id: 1,
                },
            ]
            this.semanas = semanas

            this.last_semana_id += semanas.length
            this.unidades[0].semanas = semanas
            //this.unidad_selected = this.unidades[0]
        }
    });
</script>
@endsection