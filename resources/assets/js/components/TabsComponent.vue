<template>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s4"><a class="active" href="#informacoes">Informações</a></li>
                <li class="tab col s4"><a href="#registros">Registros</a></li>
                <li class="tab col s4"><a href="#configuracoes">Configurações</a></li>
            </ul>
        </div>
        <div id="informacoes" class="col s12">Test 1</div>
        <div id="registros" class="col s12">Test 2</div>
        <div id="configuracoes" class="col s12">Test 3</div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            jQuery(this.$els.modal).modal('show')
        }
    }
</script>
