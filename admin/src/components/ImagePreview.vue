<template>
    <div class="flex flex-wrap gap-1">
        <div v-for="image of imageUrls" :key="image.id" class="relative w-[120px] h-[120px] rounded border border-dashed flex items-center justify-center
                hover:border-purple-500 overflow-hidden">
                <img :src="image.url" class="max-w-full max-h-full">
                <span class="absolute top-1 right-1 cursor-pointer" @click="removeImage(image)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
        </div>
        <div class="relative w-[120px] h-[120px] rounded border border-dashed flex items-center justify-center
                hover:border-purple-500 overflow-hidden">
            <span>Upload</span>
            <input type="file" class="absolute left-0 top-0 bottom-0 right-0 w-full h-full"
                    @change="onFileChange" multiple>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import {v4 as uuidv4} from 'uuid';

const files = ref([])
const deletedImages = ref([])

// v-model:deleted-images="product.deleted_images"
const props = defineProps(['modelValue', 'deletedImages', 'images'])
const emit = defineEmits(['update:modelValue', 'update:deletedImages'])
const imageUrls = ref([])

function onFileChange($event){
    const selectedFiles = [...$event.target.files]//[File]
    files.value = [...files.value, ...selectedFiles]//[0: File, 1: File, 2: File]
    $event.target.value=''
    for(let file of selectedFiles){
        file.id = uuidv4()
        readFile(file)
            .then(url=>{
                imageUrls.value.push({
                    url,
                    id: file.id
                })
            })
    }
    emit('update:modelValue', files.value)
}


function readFile(file){
    return new Promise((resolve, reject)=>{
        const fileReader = new FileReader()
        //This method reads the file content as a Data URL.
        //A Data URL is a base64-encoded representation of the file that can be directly used as the src of an <img> element.
        fileReader.readAsDataURL(file)
        //When the file has been successfully read, the onload event fires,
        //and the file's content (accessible via fileReader.result) is passed to the Promise's resolve() function.
        fileReader.onload = ()=>{
            resolve(fileReader.result)
        }
        //If an error occurs while reading the file, the onerror event triggers, and the Promise is rejected.
        fileReader.onerror = reject
    })
}

function removeImage(image){
    if(image.isProp){
        deletedImages.value.push(image.id)
        image.deleted = true
        imageUrls.value = imageUrls.value.filter(im=>im.id !== image.id)
        emit('update:deletedImages', deletedImages.value)
    }else{
        files.value = files.value.filter(f=>f.id !== image.id)
        imageUrls.value = imageUrls.value.filter(i=>i.id !== image.id)
        emit('update:modelValue', files.value)
    }
}


// watch('props.images',()=>{
//     imageUrls.value = [
//         ...imageUrls.value,
//         ...props.images.map(im=>({
//             ...im,
//             isProp: true
//         }))
//     ]
// }, {
//     immediate: true,
//     deep: true
// })

onMounted(()=>{
    setTimeout(()=>{
        imageUrls.value = [...props.images.map(im=>({...im, isProp: true}))]
    }, 100)
    emit('update:modelValue', [])
    emit('update:deletedImages', deletedImages.value)
})

</script>
