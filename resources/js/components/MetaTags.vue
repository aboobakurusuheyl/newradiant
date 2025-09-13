<template>
  <!-- This component doesn't render anything visible -->
</template>

<script setup>
import { onMounted, watch } from 'vue'

const props = defineProps({
  title: {
    type: String,
    default: 'New Radiant SC - Pride of Maldivian Football'
  },
  description: {
    type: String,
    default: 'Established 1979. Join our academy, support our first team, and be part of Maldivian football history.'
  },
  image: {
    type: String,
    default: '/og-image.svg'
  },
  type: {
    type: String,
    default: 'website'
  },
  url: {
    type: String,
    default: ''
  }
})

const updateMetaTag = (property, content) => {
  // Update existing meta tag or create new one
  let meta = document.querySelector(`meta[property="${property}"]`) || 
             document.querySelector(`meta[name="${property}"]`)
  
  if (meta) {
    meta.setAttribute('content', content)
  } else {
    meta = document.createElement('meta')
    if (property.startsWith('og:')) {
      meta.setAttribute('property', property)
    } else {
      meta.setAttribute('name', property)
    }
    meta.setAttribute('content', content)
    document.head.appendChild(meta)
  }
}

const updateTitle = (title) => {
  document.title = title
}

const updateMetaTags = () => {
  updateTitle(props.title)
  updateMetaTag('description', props.description)
  updateMetaTag('og:title', props.title)
  updateMetaTag('og:description', props.description)
  updateMetaTag('og:image', props.image)
  updateMetaTag('og:type', props.type)
  updateMetaTag('og:url', props.url || window.location.href)
  updateMetaTag('twitter:title', props.title)
  updateMetaTag('twitter:description', props.description)
  updateMetaTag('twitter:image', props.image)
}

onMounted(() => {
  updateMetaTags()
})

watch(() => [props.title, props.description, props.image, props.type, props.url], () => {
  updateMetaTags()
}, { deep: true })
</script>
