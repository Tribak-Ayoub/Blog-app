<script setup>
import { ref, watch, onBeforeUnmount } from 'vue'
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import Placeholder from '@tiptap/extension-placeholder'

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
        <!-- Editor Tabs -->
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

        <!-- Toolbar -->
        <div v-if="activeTab === 'write'"
            class="flex flex-wrap items-center gap-1 p-2 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center gap-1 px-1">
                <!-- Text Formatting -->
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

            <!-- Headings -->
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

            <!-- Lists -->
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

            <!-- Code & Links -->
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

            <!-- Media & Utilities -->
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

        <!-- Editor Content -->
        <div v-if="activeTab === 'write'" class="min-h-[300px] max-h-[600px] overflow-y-auto">
            <EditorContent :editor="editor" class="prose prose-sm max-w-none p-5 focus:outline-none" />
        </div>

        <!-- Preview Mode -->
        <div v-else class="min-h-[300px] max-h-[600px] overflow-y-auto p-5 prose prose-sm max-w-none bg-white"
            v-html="editor.getHTML()"></div>

        <!-- Editor Footer -->
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
/* Base editor styles */
.tiptap-editor .ProseMirror {
    outline: none;
    min-height: 300px;
}

/* Placeholder styling */
.tiptap-editor .ProseMirror p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    color: #9ca3af;
    pointer-events: none;
    height: 0;
}

/* Improve code block styling */
.tiptap-editor .ProseMirror pre {
    background-color: #f3f4f6;
    border-radius: 0.5rem;
    padding: 1rem;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.875rem;
    line-height: 1.5;
    overflow-x: auto;
}

/* Improve image styling */
.tiptap-editor .ProseMirror img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

/* Blockquote styling */
.tiptap-editor .ProseMirror blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    color: #4b5563;
    font-style: italic;
}

/* Heading styles */
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

/* List styling */
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

/* Link styling */
.tiptap-editor .ProseMirror a {
    color: #2563eb;
    text-decoration: underline;
    text-underline-offset: 2px;
}

/* Code styling */
.tiptap-editor .ProseMirror code {
    background-color: #f3f4f6;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.875em;
}
</style>