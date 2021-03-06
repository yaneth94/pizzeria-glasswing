<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pizzeria Glasswing</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('clientes/css/normalize.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('clientes/css/skeleton.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('clientes/css/custom.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">

</head>
<body  >
 <div id="confirmacion" v-cloak class="container-fluid">
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="four columns">
                    <h3>Pizzeria Glasswing</h3>
                </div>
                <div class="one columns u-pull-right ">
                    <ul>
                        <li class="submenu">
                            <img src="{{ asset('clientes/img/cart.png') }}" id="img-carrito">

                                <div id="carrito">
                                        <table id="lista-carrito" class="u-full-width">
                                            <thead>
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="car in carrito">
                                                    <td >
                                                       <img v-bind:src="car['img'] | toCard"  >
                                                    </td>
                                                    <td> @{{ car['name_pizza'] }} </td>
                                                    <td> @{{ totalSum(car.extraIngredients,car.price) }} </td>
                                                    <td>
                                                        <a class="borrar-curso"  v-on:click.prevent="deleteCarrito(car)"> X </a>
                                                    </td>
                                            </tbody>
                                        </table>
                                        <a id="vaciar-carrito" class="button u-full-width" v-on:click.prevent="cleanCarrito">Vaciar Carrito</a>
                                        <a  class="u-full-width button button-custom-agregar input" data-id="1" v-on:click.prevent="saveStorage">Realizar Pedido</a>
                                </div>

                        </li>
                    </ul>
                </div>
                @auth
                <div class="one columns u-pull-right">
                    <ul>
                        <li >
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('clientes/img/exit.png') }}" >
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
     </header>


        <div id="hero">
            <div class="container">
                <div class="row">
                        <div class="six columns">
                            <div class="contenido-hero">
                                    <h2>¿Qué desea comer?</h2>
                                    @auth
                                    <p style="color:white; margin: 1px">Revisa tus Pedidos</p>
                                    <a href="" class="button button-custom" data-id="1">Mis Pedidos</a>
                                    @else
                                    <p style="color:white; margin:1px">Para poder realizar pedidos</p>
                                    <a href="{{route('login')}}" class="button button-custom" data-id="1">Ingrese a su cuenta</a>
                                    <p style="color:white; margin:1px">Crear su cuenta</p>
                                    <a href="{{route('register')}}" class="button button-custom" data-id="1">Registrarse</a>

                                    @endauth

                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="barra">
            <div class="container">
                <div class="row">
                        <div class="four columns icono icono1">
                            <p>Deliciosas Pizzas <br>
                            Con ingredientes de Calidad</p>
                        </div>
                        <div class="four columns icono icono2">
                            <p>Cocineros Expertos <br>
                            Preparan su pizza</p>
                        </div>
                        <div class="four columns icono icono3">
                            <p>Entrega a Domicilio <br>
                            Rapidamente</p>
                        </div>
                </div>
            </div>

        </div>
        <div class="container" style="margin-top:10px">

                <h3>Confirme su orden</h3>

            <table class="u-full-width">
                <thead>
                  <tr>
                    <th>Nombre de la Pizza</th>
                    <th>Precio original</th>
                    <th>Subtotal</th>
                    <th>Ingredientes Extra</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="car in carrito">
                    <td>@{{ car.name_pizza }}</td>
                    <td>@{{car.price}}</td>
                    <td>@{{ totalSum(car.extraIngredients,car.price) }}</td>
                    <td v-if="car.extraIngredients">
                       <ul v-for="ingredient in car.extraIngredients">
                        <ol>@{{ ingredient.name_ingredient}} </ol>
                       </ul>
                    </td>
                    <td v-else>
                        No hay Ingredientes Extra
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td>@{{calculateAmount()}}</td>
                    </tr>
                </tfoot>
              </table>
              <a class="u-full-width button button-custom input agregar-carrito"  data-id="1" v-on:click.prevent="sendData">Confirmar Orden</a>
              <a href="/" id="vaciar-carrito" class="button u-full-width" >Cancelar</a>
        </div>

 </div>


     <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
    <script src="https://unpkg.com/axios@0.19.0/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/custom/pedidos/confirmacion.js') }}"></script>

</body>
</html>

