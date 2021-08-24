<template>
    <div class="form-create">
        <modal-window
            :modal-id="modalId"
            title="Редагувати користувача"
            button-text-open="Редагувати"
            button-text-success="Зберегти"
            button-text-close="Відиіна"
            @success="onSubmit"
        >
            <div class="form-area">
                <input
                    type="text"
                    ref="name"
                    class="input-modal"

                    id="userName"
                    v-model="userName"
                    placeholder="Імя користувача"
                >
                <!-- /.input-modal -->
                <input
                    type="text"
                    v-model="userEmail"
                    ref="email"
                    class="input-modal"
                    placeholder="Email"
                >
                <!-- /.input-modal -->
                <input
                    type="tel"
                    ref="phone"
                    v-model="userPhone"
                    class="input-modal"
                    id="userPhone"
                    placeholder="Телефон"
                >
                <!-- /.input-modal -->
                <input
                    type="password"
                    v-model="password"
                    class="input-modal"
                    placeholder="Пароль"
                >
                <!-- /.input-modal -->
                <input
                    type="password"
                    v-model="passwordConfirm"
                    class="input-modal"
                    placeholder="Повтор паролю"
                >
                <select v-model="userRole" class="input-modal">
                    <option  disabled selected value="0">Обрати роль</option>
                    <option value="41">Звичайний користувач</option>
                    <option value="74">Модератор</option>
                    <option value="185">Адміністратор</option>
                </select>

            </div>
            <!-- /.form-area -->


        </modal-window>
    </div>
    <!-- /.form-create -->
</template>

<script>
import Swal from 'sweetalert2'
import Inputmask from 'inputmask'
export default {
    props:{
        userId:{
            type: String,
        },
        userName:{
            type: String,
        },
        userPhone:{
            type: String,
        },
        userEmail:{
            type: String,
        },
        userRole:{
            type: String,
        },
    },
    computed:{
        modalId(){
            return 'modal-' + this.userId;
        }
    },
    data(){
        return {
            name: '',
            password: '',
            passwordConfirm: '',
            email: '',
            phone: '',
            role: 0,
            inputMaskName: '',
            inputMaskEmail: '',
            inputMaskPhone: '',
        }
    },
    methods:{
        isValidData(){
            if (!this.inputMaskPhone.isComplete() ||
                !this.inputMaskEmail.isComplete() ||
                !this.inputMaskName.isComplete()) {
                Swal.fire({
                    title: 'Некоректно вказані дані в формі!',
                    icon: 'error',
                });
                return false;
            } else {
                return true;
            }
        },
        isValidPassword(pwd, pwdConf) {
             if(pwd !== pwdConf) {
                Swal.fire({
                    title: 'Паролі не співпали!',
                    icon: 'error'
                });
                return false;
            } else {
                return true;
            }
        },
        getDataForm(){
            return {
                userId: this.userId,
                name: this.userName.replace(/\_/g, ''),
                password: this.password,
                email: this.userEmail,
                phone: this.userPhone,
                role: this.userRole,
            }
        },
        onSubmit(){
            if (!this.isValidPassword(this.password, this.passwordConfirm)) {
                return ;
            }
            if (!this.isValidData()) {
                return ;
            }
            // TODO Придумати кращу систему передавать шляхт
            axios.post('/panel/user/update', this.getDataForm())
                .then(resp => {
                    console.log('OnSubmit 3', resp)
                    if (resp.data.ok) {
                        Swal.fire({
                            title: 'Користувача ' + this.userName +  '(id-' + this.userId + ') - оновлено.',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Помилка створення!',
                            icon: 'error'
                        });
                    }
                }).catch(err => {
                Swal.fire({
                    title: 'Помилка запиту створення!',
                    icon: 'error'
                });
            })
        }
    },
    watch:{

    },
    mounted(){
        this.inputMaskPhone = Inputmask('+38 (099) 999-99-99').mask(this.$refs.phone);
        this.inputMaskEmail = Inputmask({alias:'email'}).mask(this.$refs.email);
        this.inputMaskName = Inputmask( {regex: '^[a-zA-Z\d\_\-]{3,30}$'} ).mask(this.$refs.name);
    }
}
</script>

<style scoped lang="scss">
.form-area{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: repeat(3, 1fr);
    column-gap: .7rem;
    row-gap: .3rem;
    padding: .7rem;
    @media (max-width: 490px) {
        grid-template-columns: repeat(1, 1fr);
        grid-template-rows: auto;
    }
    .border-red{
        border: 1px solid red;
        margin: .7rem;
        transition: all ease .5s;
    }
    .border-green{
        border: 1px solid green;
        margin: .2rem;
        transition: all ease .5s;
    }
    .input-modal{
        padding: .3rem .4rem;
        outline: none;
        border: 1px solid skyblue;
        border-radius: 13px;
    }
    .input-modal:nth-child(1){
        grid-column: 1/2;
        grid-row: 1/2;
    }
    .input-modal:nth-child(2){
        grid-column: 1/2;
        grid-row: 2/3;
    }
    .input-modal:nth-child(3){
        grid-column: 1/2;
        grid-row: 3/4;
    }
    .input-modal:nth-child(4){
        grid-column: 3/4;
        grid-row: 1/2;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }
    .input-modal:nth-child(5){
        grid-column: 3/4;
        grid-row: 2/3;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }

    .input-modal:nth-child(6){
        grid-column: 3/4;
        grid-row: 3/4;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }
    .input-modal:nth-child(7){
        grid-column: 3/4;
        grid-row: 2/3;
    }
    .input-modal:nth-child(8){
        grid-column: 3/4;
        grid-row: 3/4;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }
    .input-modal:nth-child(9){
        grid-column: 3/4;
        grid-row: 4/5;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }
    .input-modal:nth-child(10){
        grid-column: 3/4;
        grid-row: 5/6;
        @media (max-width: 490px) {
            grid-column: 1/2;
            grid-row: auto;
        }
    }
}
</style>
