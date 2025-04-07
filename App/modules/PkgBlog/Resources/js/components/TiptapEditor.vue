<!-- <script setup>
import { ref, watch, onBeforeUnmount } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'
import { CharacterCount } from '@tiptap/extension-character-count';


const props = defineProps({
    modelValue: String,
})
const emit = defineEmits(['update:modelValue'])

const editor = ref(
    new Editor({
        extensions: [
            StarterKit,
            Image,
            Link.configure({
                openOnClick: false,
            }),
            Placeholder.configure({
                placeholder: 'Start writing your amazing content...',
            }),
        ],
        content: props.modelValue,
        onUpdate: ({ editor }) => {
            emit('update:modelValue', editor.getHTML())
        },
    })
)

// console.log(editor.value.storage);
console.log(editor.value)

watch(() => props.modelValue, (value) => {
    if (editor.value && value !== editor.value.getHTML()) {
        editor.value.commands.setContent(value)
    }
})

onBeforeUnmount(() => {
    editor.value?.destroy()
})

// Image upload logic
const insertImage = async (event) => {
    const file = event.target.files[0]
    if (!file) return

    const formData = new FormData()
    formData.append('image', file)

    const response = await fetch('/api/upload-image', {
        method: 'POST',
        body: formData,
    })

    const result = await response.json()
    const imageUrl = result.url

    editor.value.chain().focus().setImage({ src: imageUrl }).run()
}

// File input reference for custom upload button
const fileInput = ref(null)
const triggerFileInput = () => {
    fileInput.value.click()
}

// Active tab state
const activeTab = ref('write')
</script>

<template>
    <div class="tiptap-editor rounded-xl border border-gray-200 shadow-sm bg-white overflow-hidden">
        <div class="flex border-b border-gray-200">
            <button @click="activeTab = 'write'" :class="[
                'px-4 py-3 text-sm font-medium transition-colors flex items-center',
                activeTab === 'write'
                    ? 'text-blue-600 border-b-2 border-blue-600'
                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
            ]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                    <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path>
                    <path d="M2 2l7.586 7.586"></path>
                    <circle cx="11" cy="11" r="2"></circle>
                </svg>
                Write
            </button>
            <button @click="activeTab = 'preview'" :class="[
                'px-4 py-3 text-sm font-medium transition-colors flex items-center',
                activeTab === 'preview'
                    ? 'text-blue-600 border-b-2 border-blue-600'
                    : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
            ]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                Preview
            </button>
        </div>

        <div v-if="activeTab === 'write'"
            class="flex flex-wrap items-center gap-1 p-2 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center gap-1 px-1">

            <button @click="editor.chain().focus().toggleBold().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('bold') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Bold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 12a4 4 0 0 0 0-8H6v8" />
                        <path d="M15 20a4 4 0 0 0 0-8H6v8Z" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleItalic().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('italic') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Italic">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" x2="10" y1="4" y2="4" />
                        <line x1="14" x2="5" y1="20" y2="20" />
                        <line x1="15" x2="9" y1="4" y2="20" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleStrike().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('strike') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Strikethrough">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12" />
                        <line x1="16" x2="9" y1="18" y2="18" />
                        <line x1="14" x2="5" y1="6" y2="6" />
                    </svg>
                </button>
            </div>

            <div class="w-px h-6 bg-gray-200 mx-1"></div>

            <div class="flex items-center gap-1 px-1">
                <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('heading', { level: 1 }) }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Heading 1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12h8" />
                        <path d="M4 18V6" />
                        <path d="M12 18V6" />
                        <path d="m17 12 3-2v8" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('heading', { level: 2 }) }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Heading 2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12h8" />
                        <path d="M4 18V6" />
                        <path d="M12 18V6" />
                        <path d="M21 18h-4c0-4 4-3 4-6 0-1.5-2-2.5-4-1" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('heading', { level: 3 }) }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Heading 3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 12h8" />
                        <path d="M4 18V6" />
                        <path d="M12 18V6" />
                        <path d="M21 15a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path d="M21 9h-6" />
                    </svg>
                </button>
            </div>

            <div class="w-px h-6 bg-gray-200 mx-1"></div>

            <div class="flex items-center gap-1 px-1">
                <button @click="editor.chain().focus().toggleBulletList().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('bulletList') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Bullet List">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" x2="21" y1="6" y2="6" />
                        <line x1="8" x2="21" y1="12" y2="12" />
                        <line x1="8" x2="21" y1="18" y2="18" />
                        <line x1="3" x2="3.01" y1="6" y2="6" />
                        <line x1="3" x2="3.01" y1="12" y2="12" />
                        <line x1="3" x2="3.01" y1="18" y2="18" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleOrderedList().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('orderedList') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Ordered List">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="10" x2="21" y1="6" y2="6" />
                        <line x1="10" x2="21" y1="12" y2="12" />
                        <line x1="10" x2="21" y1="18" y2="18" />
                        <path d="M4 6h1v4" />
                        <path d="M4 10h2" />
                        <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleBlockquote().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('blockquote') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Blockquote">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z" />
                        <path
                            d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z" />
                    </svg>
                </button>
            </div>

            <div class="w-px h-6 bg-gray-200 mx-1"></div>

            <div class="flex items-center gap-1 px-1">
                <button @click="editor.chain().focus().toggleCodeBlock().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('codeBlock') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Code Block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6" />
                        <polyline points="8 6 2 12 8 18" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().toggleCode().run()"
                    :class="{ 'bg-blue-100 text-blue-700': editor.isActive('code') }"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Inline Code">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 20H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v5" />
                        <path d="M18 15v6" />
                        <path d="M21 18h-6" />
                    </svg>
                </button>
            </div>

            <div class="w-px h-6 bg-gray-200 mx-1"></div>

            <div class="flex items-center gap-1 px-1">
                <button @click="triggerFileInput" class="p-1.5 rounded-md hover:bg-gray-100 transition-colors"
                    title="Insert Image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                </button>
                <input ref="fileInput" type="file" accept="image/*" @change="insertImage" class="hidden" />
                <button @click="editor.chain().focus().undo().run()"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Undo"
                    :disabled="!editor.can().undo()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 7v6h6" />
                        <path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().redo().run()"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Redo"
                    :disabled="!editor.can().redo()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 7v6h-6" />
                        <path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7" />
                    </svg>
                </button>
                <button @click="editor.chain().focus().unsetAllMarks().clearNodes().run()"
                    class="p-1.5 rounded-md hover:bg-gray-100 transition-colors" title="Clear Formatting">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21" />
                        <path d="M22 21H7" />
                        <path d="m5 11 9 9" />
                    </svg>
                </button>
            </div>
        </div>

        <div v-if="activeTab === 'write'" class="min-h-[300px] max-h-[600px] overflow-y-auto">
            <EditorContent :editor="editor" class="prose prose-sm max-w-none p-5 focus:outline-none" />
        </div>

        <div v-else class="min-h-[300px] max-h-[600px] overflow-y-auto p-5 prose prose-sm max-w-none bg-white"
            v-html="editor.getHTML()"></div>

        <div
            class="flex items-center justify-between px-4 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500">
            <div>
                <span>{{ editor.storage.characterCount.characters() }} characters</span>
                <span class="mx-2">•</span>
                <span>{{ editor.storage.characterCount.words() }} words</span>
            </div>
            <div>
                <span>Markdown supported</span>
            </div>
        </div>
    </div>
</template>

<style>
.tiptap-editor .ProseMirror {
    outline: none;
    min-height: 300px;
}

.tiptap-editor .ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: #9ca3af;
    pointer-events: none;
    height: 0;
}

.tiptap-editor .ProseMirror pre {
    background-color: #f3f4f6;
    border-radius: 0.5rem;
    padding: 1rem;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.875rem;
    line-height: 1.5;
    overflow-x: auto;
}

.tiptap-editor .ProseMirror img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.tiptap-editor .ProseMirror blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    color: #4b5563;
    font-style: italic;
}

.tiptap-editor .ProseMirror h1 {
    font-size: 1.875rem;
    line-height: 2.25rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.tiptap-editor .ProseMirror h2 {
    font-size: 1.5rem;
    line-height: 2rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.tiptap-editor .ProseMirror h3 {
    font-size: 1.25rem;
    line-height: 1.75rem;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.tiptap-editor .ProseMirror ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin: 1rem 0;
}

.tiptap-editor .ProseMirror ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin: 1rem 0;
}

.tiptap-editor .ProseMirror a {
    color: #2563eb;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.tiptap-editor .ProseMirror code {
    background-color: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.875em;
}
</style> -->

<template>
    <div class="editor-container">
        <!-- Toolbar -->
        <div v-if="editor" class="editor-toolbar">
            <!-- Text Formatting -->
            <button @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'is-active': editor.isActive('bold') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                    <path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                </svg>
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'is-active': editor.isActive('italic') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="4" x2="10" y2="4"></line>
                    <line x1="14" y1="20" x2="5" y2="20"></line>
                    <line x1="15" y1="4" x2="9" y2="20"></line>
                </svg>
            </button>
            <button @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'is-active': editor.isActive('underline') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"></path>
                    <line x1="4" y1="21" x2="20" y2="21"></line>
                </svg>
            </button>
            <button @click="editor.chain().focus().toggleStrike().run()"
                :class="{ 'is-active': editor.isActive('strike') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
            </button>

            <!-- Headings -->
            <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
                H1
            </button>
            <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
                H2
            </button>
            <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
                H3
            </button>

            <!-- Text Alignment -->
            <button @click="editor.chain().focus().setTextAlign('left').run()"
                :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="9" y2="18"></line>
                </svg>
            </button>
            <button @click="editor.chain().focus().setTextAlign('center').run()"
                :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="12" x2="12" y2="12"></line>
                    <line x1="8" y1="6" x2="16" y2="6"></line>
                    <line x1="6" y1="18" x2="18" y2="18"></line>
                </svg>
            </button>
            <button @click="editor.chain().focus().setTextAlign('right').run()"
                :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="15" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- Lists -->
            <button @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active': editor.isActive('bulletList') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
            </button>
            <button @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'is-active': editor.isActive('orderedList') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="10" y1="6" x2="21" y2="6"></line>
                    <line x1="10" y1="12" x2="21" y2="12"></line>
                    <line x1="10" y1="18" x2="21" y2="18"></line>
                    <path d="M4 6h1v4"></path>
                    <path d="M4 10h2"></path>
                    <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
                </svg>
            </button>

            <!-- Code -->
            <button @click="editor.chain().focus().toggleCodeBlock().run()"
                :class="{ 'is-active': editor.isActive('codeBlock') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="16 18 22 12 16 6"></polyline>
                    <polyline points="8 6 2 12 8 18"></polyline>
                </svg>
            </button>

            <!-- Blockquote -->
            <button @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{ 'is-active': editor.isActive('blockquote') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </button>

            <!-- Horizontal Rule -->
            <button @click="editor.chain().focus().setHorizontalRule().run()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>

            <!-- Link -->
            <button @click="setLink" :class="{ 'is-active': editor.isActive('link') }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
            </button>

            <!-- Image Upload -->
            <button @click="addImage">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </button>

            <!-- YouTube Video -->
            <button @click="addYoutubeVideo">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                    </path>
                    <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                </svg>
            </button>

            <!-- Undo/Redo -->
            <button @click="editor.chain().focus().undo().run()" :disabled="!editor.can().undo()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10h10a4 4 0 0 1 0 8H5a4 4 0 0 1 0-8h1"></path>
                    <polyline points="7 10 3 6 7 2"></polyline>
                </svg>
            </button>
            <button @click="editor.chain().focus().redo().run()" :disabled="!editor.can().redo()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10H11a4 4 0 0 0 0 8h8a4 4 0 0 0 0-8h1"></path>
                    <polyline points="17 10 21 6 17 2"></polyline>
                </svg>
            </button>
        </div>

        <!-- Bubble Menu (appears when selecting text) -->
        <bubble-menu class="bubble-menu" :tippy-options="{ duration: 100 }" :editor="editor" v-if="editor">
            <button @click="editor.chain().focus().toggleBold().run()"
                :class="{ 'is-active': editor.isActive('bold') }">
                Bold
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()"
                :class="{ 'is-active': editor.isActive('italic') }">
                Italic
            </button>
            <button @click="editor.chain().focus().toggleUnderline().run()"
                :class="{ 'is-active': editor.isActive('underline') }">
                Underline
            </button>
            <button @click="setLink" :class="{ 'is-active': editor.isActive('link') }">
                Link
            </button>
        </bubble-menu>

        <!-- Editor Content -->
        <editor-content :editor="editor" class="editor-content" />
    </div>
</template>

<script setup>
import { Editor, EditorContent, BubbleMenu } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import Youtube from '@tiptap/extension-youtube'
import TextAlign from '@tiptap/extension-text-align'
import { useToast } from 'vue-toastification'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])
const toast = useToast()

const editor = ref(null)

onMounted(() => {
    editor.value = new Editor({
        content: props.modelValue,
        extensions: [
            StarterKit,
            Underline,
            Link.configure({
                openOnClick: false,
                HTMLAttributes: {
                    class: 'text-blue-500 hover:underline',
                    rel: 'noopener noreferrer',
                },
            }),
            Image.configure({
                HTMLAttributes: {
                    class: 'rounded-lg max-w-full h-auto',
                },
            }),
            Youtube.configure({
                inline: false,
                HTMLAttributes: {
                    class: 'rounded-lg',
                },
            }),
            TextAlign.configure({
                types: ['heading', 'paragraph'],
            }),
        ],
        onUpdate: () => {
            emit('update:modelValue', editor.value.getHTML())
        },
    })
})

onBeforeUnmount(() => {
    editor.value?.destroy()
})

// Methods
const setLink = () => {
    const previousUrl = editor.value.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)

    if (url === null) return

    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
        return
    }

    editor.value
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: url })
        .run()
}

const addImage = async () => {
    const input = document.createElement('input')
    input.type = 'file'
    input.accept = 'image/*'

    input.onchange = async () => {
        if (input.files?.length) {
            const file = input.files[0]

            try {
                // Create a temporary placeholder
                const placeholderId = `image-${Date.now()}`
                editor.value.commands.setImage({
                    src: '',
                    'data-placeholder': placeholderId,
                })

                // Upload the image
                const formData = new FormData()
                formData.append('image', file)

                const { data } = await axios.post('/api/upload-image', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })

                // Replace placeholder with actual image
                const tr = editor.value.state.tr
                const doc = editor.value.state.doc
                let found = false

                doc.descendants((node, pos) => {
                    if (found) return false
                    if (node.type.name === 'image' && node.attrs['data-placeholder'] === placeholderId) {
                        tr.setNodeMarkup(pos, undefined, {
                            ...node.attrs,
                            src: data.url,
                            alt: file.name,
                            'data-placeholder': undefined,
                        })
                        found = true
                        return false
                    }
                })

                if (found) {
                    editor.value.view.dispatch(tr)
                }
            } catch (error) {
                toast.error('Failed to upload image')
                console.error('Image upload error:', error)

                // Remove the placeholder if upload fails
                const tr = editor.value.state.tr
                const doc = editor.value.state.doc

                doc.descendants((node, pos) => {
                    if (node.type.name === 'image' && node.attrs['data-placeholder'] === placeholderId) {
                        tr.delete(pos, pos + node.nodeSize)
                        return false
                    }
                })

                editor.value.view.dispatch(tr)
            }
        }
    }

    input.click()
}

const addYoutubeVideo = () => {
    const url = prompt('Enter YouTube URL:')

    if (url) {
        editor.value.commands.setYoutubeVideo({
            src: url,
            width: 640,
            height: 480,
        })
    }
}
</script>

<style scoped>
.editor-container {
    @apply border border-gray-200 rounded-lg overflow-hidden;
}

.editor-toolbar {
    @apply flex flex-wrap items-center gap-1 p-2 border-b border-gray-200 bg-gray-50;
}

.editor-toolbar button {
    @apply p-2 rounded text-gray-700 hover:bg-gray-200 transition-colors flex items-center justify-center;
}

.editor-toolbar button.is-active {
    @apply bg-gray-200 text-blue-600;
}

.editor-toolbar button:disabled {
    @apply opacity-50 cursor-not-allowed;
}

.bubble-menu {
    @apply flex bg-white p-1 shadow-lg rounded-md border border-gray-200;
}

.bubble-menu button {
    @apply px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded;
}

.bubble-menu button.is-active {
    @apply bg-gray-100 text-blue-600;
}

.editor-content {
    @apply min-h-[300px] p-4 outline-none;
}

/* ProseMirror specific styles */
:deep(.ProseMirror) {
    @apply min-h-[300px] outline-none;
}

:deep(.ProseMirror:focus) {
    @apply outline-none;
}

:deep(.ProseMirror p) {
    @apply mb-4;
}

:deep(.ProseMirror img) {
    @apply max-w-full h-auto;
}

:deep(.ProseMirror img.ProseMirror-selectednode) {
    @apply outline-2 outline-blue-500;
}

:deep(.ProseMirror .iframe-wrapper) {
    @apply relative pb-[56.25%] h-0 overflow-hidden my-4;
}

:deep(.ProseMirror iframe) {
    @apply absolute top-0 left-0 w-full h-full border-0;
}

:deep(.ProseMirror .text-align-left) {
    @apply text-left;
}

:deep(.ProseMirror .text-align-center) {
    @apply text-center;
}

:deep(.ProseMirror .text-align-right) {
    @apply text-right;
}
</style>