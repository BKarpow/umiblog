<template>
    <div class="cartBox">
        <div class="wrapper_cart"
             @mouseover="mouseExists"
             @mouseout="mouseNonExists"
        >
            <div class="cart" ref="cart">
                <h2 class="cart__title">{{title}}</h2>
                <!-- /.cart__title -->
            </div>
            <!-- /.cart -->
            <div class="cart__back blur" ref="back">
                <!--  -->
                <p> {{short}} </p>
                <footer>
                    <a :href="href" class="btn__show-more">
                        Більше
                    </a>
                    <!-- /.btn__show-more -->
                </footer>
            </div>
            <!-- /.cart__back -->
        </div>
        <!-- /.wrapper_cart -->
    </div>
</template>

<script>
export default {
    props: {
        shortContent: {
            type:String,
            default: '',
        },
        title:{
            type: String,
            default: 'Title',
        },
        image:{
            type:String,
            default: '',
        },
        href:{
            type: String,
            default: '#',
        },
    },
    data() {
        return {
            classActive: 'cart_active',
            classBlur: 'blur',
        };
    },
    mounted(){
        if (this.image.length > 0) { this.$refs.cart.style.backgroundImage =
            'linear-gradient(to bottom, #000, transparent 95%), url("' + this.image + '")';
            console.log(this.$refs.cart.style.backgroundImage)
        }
    },
    computed:{
        short(){
            return this.shortContent.substring(0, 210) + '...'
        }
    },
methods: {
    mouseExists(){
        this.$refs.cart.classList.add(this.classActive);
        this.$refs.back.classList.remove(this.classBlur);
    },
    mouseNonExists(){
        this.$refs.cart.classList.remove(this.classActive);
        this.$refs.back.classList.add(this.classBlur);
    },
}
};
</script>

<!-- Use preprocessors via the lang attribute! e.g. <style lang="scss"> -->
<style lang="scss" scoped>


.cartBox{
    color: #fff;
    width: auto;
    display: inline-block;
}
.blur{
    filter:blur(.5rem);
    transition: all .8s;
    transition-delay: .2s;
}
.wrapper_cart{
    position: relative;
    display: inline-block;

    perspective: 400px;
    .cart__back{
        padding: .7rem;
        width: 320px;
        height: 280px;
        border: 1px solid #000;
        background-color: #111;
        transition: all .8s;
        transition-delay: .2s;
        overflow: auto;
        p{
            line-height: 14px;
        }
        footer{
            margin-top: .7rem;
            .btn__show-more{
                display: block;
                outline: none;
                width: 95%;
                border-radius: 9px;
                border: 1px solid white;
                background: inherit;
                color: inherit;
                text-transform: uppercase;
                text-decoration: none;
                text-align: center;
                letter-spacing: 12px;
                font-weight: bold;
                padding: 1rem;
                transition: all .5s ease;
                &:hover{
                    background: white;
                    color: black;
                    text-decoration: none;
                    transition: all .5s ease;
                }
                &:active{
                    transform: translate(+4%, -4%);
                    text-decoration: none;
                    transition: all .1s ease;
                }
            }
        }

    }
    .cart_active{
        z-index: 2;
        transform: scale3d(0,0,0);
        transition: all .8s ease ;
        transition-delay: .4s;
        // transition-timing-function: cubic-bezier(0.75, -1, 0.21, -1);
    }
    .cart{
        padding: .2rem .7rem;
        position: absolute;
        top: 0;
        opacity: .9;
        left: 0;
        display: block;
        width: 320px;
        height: 300px;
        z-index: 1;
        border-radius: 6px;
        border: 1px solid #fff;
        background-image:
            linear-gradient(to bottom,
                #000,
                transparent 95%) ;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        aspect-ratio: 1.5/1;
        transition: all .8s ease;
        backface-visibility: hidden;
        transition-delay: .2s;
        h2{
            line-height: 30px;
            letter-spacing: 4px;
            text-transform: uppercase;
            padding: 0;
            margin-top: .7rem;
            margin-bottom: .5rem;
            font-family: sans-serif;
            font-weight: bold;
            font-size: 20px;
        }
    }
}
</style>
