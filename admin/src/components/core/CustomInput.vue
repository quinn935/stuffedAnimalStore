<template>
    <div>
      <div class="mt-1 flex rounded-md shadow-sm">
        <span v-if="prepend"
              class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
          {{ prepend }}
        </span>
        <template v-if="type === 'textarea'">
            <div class="my-2 w-full">
                <label class="inline-block mb-1">{{ label }}</label>
            <textarea :name="name"
                    :required="required"
                    :value="props.modelValue"
                    @input="emit('update:modelValue', $event.target.value)"
                     :class="inputClasses"
                    class="h-36"
                    :placeholder="label"></textarea>
            </div>
        </template>
        <template v-else-if="type === 'select' && selectOptions">
            <div class="my-3 w-full">
                <select
                        :name="name"
                        :required="required"
                        @change="onChange($event.target.value)"
                        :value="modelValue"
                        :class="inputClasses">
                        <option v-for="option of selectOptions" :value="option.key">{{ option.text }}</option>
                </select>
          </div>
        </template>
        <template v-else-if="type === 'select' && states">
          <select
                 :name="name"
                 :required="required"
                 :value="modelValue"
                 :class="inputClasses"
                 @change="emit('update:modelValue', $event.target.value)
                 ">
                 <option v-for="[code, state] of Object.entries(states) " :key="code" :value="code">{{ state }}</option>
          </select>
        </template>
        <template v-else-if="type === 'file'">
            <div class="w-full my-3">
                <label>{{ label }}</label>
                  <input :type="type"
                 :name="name"
                 :required="required"
                 @change="emit('change', $event.target.files[0])"
                 :class="inputClasses"/>
             </div>
        </template>
        <template v-else-if="type === 'checkbox'">
            <div class="my-3 ml-1 w-full flex">
                <input  :type="type" :id="id" :name="name" :checked="props.modelValue" :required="required"
                        @change="emit('update:modelValue', $event.target.checked)"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label :for="id" class="ml-2 block text-sm text-gray-900">{{ label }}</label>
            </div>
        </template>
        <template v-else>
            <div class="w-full my-2">
                <label class="inline-block mb-1">{{ label }}</label>
                <input :type="type"
                        :name="name"
                        :required="required"
                        :value="props.modelValue"
                        @change="emit('update:modelValue', $event.target.value)"
                        :class="inputClasses"
                        :placeholder="label"
                        step="0.01"/>
             </div>
        </template>
        <span v-if="append"
              class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
          {{ append }}
        </span>
      </div>
    </div>
  </template>

  <script setup>

  import {computed, ref} from "vue";

  const props = defineProps({
    modelValue: [String, Number, File, Boolean],
    label: String,
    type: {
      type: String,
      default: 'text'
    },
    name: String,
    required: Boolean,
    prepend: {
      type: String,
      default: ''
    },
    append: {
      type: String,
      default: ''
    },
    selectOptions: Array,
    states: Object
  })


  const id = computed(()=>{
    if(props.id) return props.id
    return Math.floor(1000000 + Math.random() * 1000000)
  })

  const inputClasses = computed(() => {
    const cls = [
      `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm`,
    ];

    if (props.append && !props.prepend) {
      cls.push(`rounded-l-md`)
    } else if (props.prepend && !props.append) {
      cls.push(`rounded-r-md`)
    } else if (!props.prepend && !props.append) {
      cls.push('rounded-md')
    }
    return cls.join(' ')
  })

  const emit = defineEmits(['update:modelValue', 'change'])

  function onChange(value){
    emit('update:modelValue', value);
    emit('change', value);
  }


  </script>

  <style scoped>

  </style>


