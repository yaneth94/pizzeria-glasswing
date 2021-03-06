new Vue({
    el: "#mispedidos",
    created() {
        this.getPedidos();
    },
    data:{
        carrito:[],
        pagination: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0
        },
        orders:[],
        errors: {},
        offset: 2,
    },
    filters:{
        toConfirm: function(value){
            console.log(value);
            if(!value)
                return 'No hay Ingredientes Extra'
            return value.join('-')
        },
        toCard: function(value){
            if(!value)
                return 'https://res.cloudinary.com/dgi2nmgsy/image/upload/w_80,h_80,c_scale/v1583767799/2747815cc4a7c1258da3f330d71bef8d_bvvree.jpg'
            return value.toString().replace('upload/','upload/w_80,h_80,c_scale/')
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return []
            }

            var from = this.pagination.current_page - this.offset
            if (from < 1) {
                from = 1
            }

            var to = from + this.offset * 2
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page
            }

            var pagesArray = []
            while (from <= to) {
                pagesArray.push(from)
                from++
            }
            return pagesArray
        }
    },
    methods: {
        getPedidos: function(){
            let url='/ordenes?page=' + this.pagination.current_page
            axios.get(url).then(response=>{
                this.orders=response.data.orders.data;
                this.pagination = response.data.pagination
            })
        },
        changePage: function (page) {
            this.pagination.current_page = page
            this.getPedidos(page)
        },
        totalSum:function(extraIngredients, price){
            if(!extraIngredients){
                return parseFloat(price).toFixed(2);
            }
            let sum =extraIngredients.reduce((acu,val)=>{
                price_ingredient= parseFloat(val.price);
                return acu+parseFloat(price_ingredient)

            } ,0);
            sum+=parseFloat(price);
            return sum.toFixed(2);
        },
        addCarrito: function(pizza){
            this.carrito = [...this.carrito,pizza];
        },
        addIngredientesExtras: function(){
              this.carrito=  [...this.carrito,this.fillPizza]
        },
        deleteCarrito: function(pizza){
            this.carrito= this.carrito.filter( el => el.id != pizza.id)
            localStorage.setItem("carrito",JSON.stringify(this.carrito))
        },
        cleanCarrito: function(){
            this.carrito=[];
            localStorage.clear();
        },
        calculateAmount: function(){
            let prices=[]

            this.carrito.forEach(el=>{
                prices.push(this.totalSum(el.extraIngredients,el.price))
            })
            let sum =prices.reduce((acu,val)=>{
                return acu+parseFloat(val);
            } ,0);
            return sum.toFixed(2);
        },

        sendData: function () {
            let url = '/pedidos';
            let pizzas=[]
            let prices=[]
            this.carrito.forEach(el=>{
                let pizza={
                    id:el.id,
                    ingredientesExtras:el.extraIngredients?el.extraIngredients.map(i => i.id):[]
                }
                prices.push(this.totalSum(el.extraIngredients,el.price))
                pizzas.push(pizza)
            })
            let sum =prices.reduce((acu,val)=>{
                return acu+parseFloat(val);
            } ,0);
            let amount = sum;
            console.log(prices);
            let envio ={
                pizzas,
                amount
            }

            axios.post(url,envio)
                .then(response => {

                        toastr.success('Pedido Realizado  con éxito')
                        setTimeout(()=>{
                            location.href='/'
                        },1000)

                })
                .catch(error => {
                    console.log(error)
                })
        },
    }

});
