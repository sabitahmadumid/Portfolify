<div x-data="enhancedRichEditor()" class="space-y-2">
    <!-- Toolbar -->
    <div class="flex flex-wrap gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-t-lg border border-gray-200 dark:border-gray-700">
        <!-- Media Insert Button -->
        <button
            type="button"
            @click="$wire.mountAction('insertMedia')"
            class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            title="Insert Media"
        >
            <x-heroicon-o-photo class="w-4 h-4 mr-1" />
            Media
        </button>

        <!-- Enhanced Table Button -->
        <button
            type="button"
            @click="$wire.mountAction('insertTable')"
            class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            title="Insert Table"
        >
            <x-heroicon-o-table-cells class="w-4 h-4 mr-1" />
            Table
        </button>

        <!-- Quick Format Buttons -->
        <div class="flex gap-1 border-l border-gray-300 dark:border-gray-600 pl-2 ml-2">
            <button
                type="button"
                @click="insertQuickFormat('**', '**', 'Bold text')"
                class="p-1.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 rounded"
                title="Bold"
            >
                <x-heroicon-s-bold class="w-4 h-4" />
            </button>
            
            <button
                type="button"
                @click="insertQuickFormat('*', '*', 'Italic text')"
                class="p-1.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 rounded"
                title="Italic"
            >
                <x-heroicon-s-italic class="w-4 h-4" />
            </button>

            <button
                type="button"
                @click="insertLink()"
                class="p-1.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 rounded"
                title="Insert Link"
            >
                <x-heroicon-o-link class="w-4 h-4" />
            </button>
        </div>
    </div>

    <!-- Rich Editor Component -->
    <div 
        x-ref="editorContainer"
        @insert-content.window="insertContentIntoEditor($event.detail.content)"
        class="border-l border-r border-b border-gray-200 dark:border-gray-700 rounded-b-lg"
    >
        {{ $this->form }}
    </div>

    <!-- Actions Modal -->
    <x-filament-actions::modals />
</div>

<script>
function enhancedRichEditor() {
    return {
        insertQuickFormat(startTag, endTag, placeholder) {
            // This would integrate with the rich editor's API
            console.log('Insert format:', startTag, endTag, placeholder);
        },

        insertLink() {
            const url = prompt('Enter URL:');
            const text = prompt('Enter link text:') || url;
            if (url) {
                const linkHtml = `<a href="${url}" target="_blank">${text}</a>`;
                this.insertContentIntoEditor(linkHtml);
            }
        },

        insertContentIntoEditor(content) {
            // Try to find the rich editor instance and insert content
            const editor = this.$refs.editorContainer.querySelector('[data-trix-editor]');
            if (editor && editor.editor) {
                editor.editor.insertHTML(content);
            } else {
                // Fallback: dispatch event to the rich editor
                this.$dispatch('rich-editor-insert', { content });
            }
        }
    }
}
</script>

<style>
/* Enhanced editor styles */
.enhanced-rich-editor .trix-content {
    min-height: 300px;
    padding: 1rem;
}

.enhanced-rich-editor table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}

.enhanced-rich-editor table td,
.enhanced-rich-editor table th {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
    text-align: left;
}

.enhanced-rich-editor table th {
    background-color: #f9fafb;
    font-weight: bold;
}

.enhanced-rich-editor img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    margin: 1rem 0;
}
</style>