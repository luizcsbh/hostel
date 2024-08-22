<template>
    <div class="form-group">
        <label :for="selectId" class="form-label">{{ titulo }}</label>
        <select :id="selectId"
                class="form-control"
                v-model="selected" 
                @change="$emit('update:selected', selected)"
                :disabled="disabled">
            <option value="" disabled>{{ texto }}</option>
            <option 
                    v-for="item in items"
                    :key="item.id"
                    :value="item.id"
            >
                {{ item.name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        titulo: {
            type: String,
            required: true
        },
        texto: {
            type: String,
            default: 'Selecione uma opção'
        },
        selectId: {
            type: String,
            required: true
        },
        items: {
            type: Array,
            required: true
        },
        
        value:{
            type: [String, Number],
            default:''
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data(){
        return {
            selected: this.value || ''
        }
    },
    watch: {
        value(newValue) {
            this.selected = newValue;
        },
        selected(newValue) {
            this.$emit('input', newValue);
        }
    }
};
</script>
