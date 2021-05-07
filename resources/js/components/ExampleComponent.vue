<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> Crear una nueva materia</div>
                <form method="POST" class="form-inline" v-on:submit.prevent=addAgenda()>
                    <div class="form-group mx-sm-3">
                        <label class="my-1 mr-2" >Materia: </label>
                        <input type="text" v-model="materia" class="form-control" placeholder="Literatura"> 
                    </div>
                    <div class="form-group mx-sm-3">
                        <label class="my-1 mr-2">Docente: </label>
                        <input type="text" v-model="docente" class="form-control" placeholder="Jon Doe">
                    </div>
                    <div class="form-group mx-sm-3">
                        <label class="my-1 mr-2">Tipo: </label>
                        <select class="custom-select my-1 mr-sm-2" v-model="selected">
                            <option value="">Seleccione el tipo de materia</option>
                            <option value="Cuantitativa">Cuantitativa</option>
                            <option value="Cualitativa">Cualitativa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                </form>
            </div>

            <h4 class="mt-5 mb-3">Listado de materias</h4>
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Materia</th>
                    <th scope="col">Docente</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="agenda in arrayAgenda" :key="agenda.id_agenda">
                    <th scope="row" v-text="agenda.id_agenda"></th>
                    <td v-text="agenda.nombre_materia"></td>
                    <td v-text="agenda.docente"></td>
                    <td v-text="agenda.tipo_materia"></td>
                    <td>
                        <button type="button" class="btn btn-secondary" @click=editAgenda(agenda)>Editar</button>
                        <button type="button" class="btn btn-danger" @click=deleteAgenda(agenda)>Borrar</button>
                    </td>
                  </tr>
                </tbody>
            </table>

            
            
            <div class="modal fade" id="EditarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Agenda</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" v-on:submit.prevent=updateAgenda()>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name_materia" class="col-form-label">Materia:</label>
                                    <input type="text" v-model="name_materia" class="form-control" id="name_materia">
                                </div>
                                <div class="form-group">
                                    <label for="docente" class="col-form-label">Docente:</label>
                                    <input type="text" v-model="name_docente" class="form-control" id="docente">
                                </div>
                                <div class="form-group">
                                    <label for="tipo_materia" class="col-form-label">Tipo:</label>
                                    <div v-if="tipo_materia == 'Cuantitativa'">
                                        <select v-model="tipo_materia" class="custom-select" id="tipo_materia">
                                            <option>Tipo</option>
                                            <option value="Cuantitativa" selected>Cuantitativa</option>
                                            <option value="Cualitativa">Cualitativa</option>
                                        </select>
                                    </div>
                                    <div v-else-if="tipo_materia == 'Cualitativa'">
                                        <select v-model="tipo_materia" class="custom-select" id="tipo_materia">
                                            <option>Seleccione el tipo de materia</option>
                                            <option value="Cuantitativa" >Cuantitativa</option>
                                            <option value="Cualitativa" selected>Cualitativa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    export default {
        
        data(){
            return{
                arrayAgenda:[],
                materia: '',
                docente: '',
                selected: '',
                name_materia: '',
                name_docente: '',
                tipo_materia: '',
                message: '',
            }
        },
        methods: {
            getAgenda(){
                axios.get('/agenda').then((response) => {
                    this.arrayAgenda = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            addAgenda(){
                axios.post('/agenda/nueva-agenda',{
                    'nombre_materia' : this.materia,
                    'docente' : this.docente,
                    'tipo_materia' : this.selected,
                }).then((response) => {
                    this.getAgenda();
                    this.clearInputs();
                    Toast.fire({
                        icon: 'success',
                        title: 'Registro de Materia exitoso'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            editAgenda(data){
                axios.get('/agenda/editar-agenda/'+data.id_agenda).
                then((response)=> {
                    $('#EditarModal').modal('show');
                    this.id = data.id_agenda;
                    this.name_materia = data.nombre_materia;
                    this.name_docente = data.docente;
                    this.tipo_materia = data.tipo_materia;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            updateAgenda(data){
                axios.put('/agenda/actualizar-agenda/'+this.id, {
                    'nombre_materia' : this.name_materia,
                    'docente' : this.name_docente,
                    'tipo_materia' : this.tipo_materia,
                }).
                then((response)=>{
                    this.getAgenda();
                    $('#EditarModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Registro de Materia Actualizado'
                    });
                    this.name_materia = '';
                    this.name_docente = '';
                    this.tipo_materia = '';

                })
            },
            deleteAgenda(data){
                if (confirm('¿Estás seguro de eliminar este registro?')){
                    axios.delete('/agenda/eliminar-agenda/'+data.id_agenda).
                    then((response)=>{
                        this.getAgenda();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                };
            },
            clearInputs(){
                this.materia= '';
                this.docente= '';
                this.selected= '';
            }
        },
        mounted() {
            this.getAgenda();
        }
    }
</script>
