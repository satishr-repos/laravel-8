<template>
<div class="container h-auto">
    <simple-card v-if="!loading" title="Recommendation" bgColor="bg-gray-50">
        <div slot="title">
        </div>
        <div slot="content">
            <tiptap-menu-bar class="flex justify-start flex-wrap p-1 border-b-2 border-gray-200" 
                :editor="editor" v-on:save-content="onSave" v-on:delete-content="onDelete" />
            <editor-content class="" :editor="editor" />
        </div>
    </simple-card>
    <confirm-dialogue ref="confirmDialogue"></confirm-dialogue>
</div>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-2'
import StarterKit from '@tiptap/starter-kit'
import TaskList from '@tiptap/extension-task-list'
import TaskItem from '@tiptap/extension-task-item'
import Highlight from '@tiptap/extension-highlight'
import TiptapMenuBar from '../Utils/TiptapMenuBar.vue'

export default {
    name: "Recommendation",

    props: {
        route: String,
    },

  components: {
    EditorContent,
    TiptapMenuBar,
  },

  data() {
    return {
      editor: null,
      loading:true,
    }
  },

  created() {
      this.recommendation = {id:-1, content:''};
  },

  mounted() {
    this.editor = new Editor({
      editable: true,
      extensions: [
        StarterKit,
        Highlight,
        TaskList,
        TaskItem,
      ],
      editorProps: {
        attributes: {
        class:
                "prose prose-lg m-5 focus:outline-none"
        }
      },
      content: `
        `,
    })
    this.loading = false;
    this.getRecommendations();
  },

  methods: {

    getRecommendations() {
        axios.get(this.route, {
                params: {
                    json: true,
                },
            })
            .then((response) => {

                let recommendation = response.data.recommendation;
                if(recommendation)
                {
                    this.recommendation = recommendation;
                    this.editor.commands.setContent(recommendation.content);
                }
            })
            .catch((error) => {

                console.log("ERROR:", error);
            }); 
    },

    onSave() 
    {
        this.recommendation.content = this.editor.getHTML();
        if(this.recommendation.id < 0)
        {
            axios.post(this.route, this.recommendation)
                .then((response) => {

                    this.recommendation = response.data.recommendation;
                })
                .catch((error) => {

                    console.log("ERROR:", error);
                }); 
        }
        else
        {
            let route = this.route + '/' + this.recommendation.id;
            axios.patch(route, this.recommendation)
                .then((response) => {

                    this.recommendation = response.data.recommendation;
                })
                .catch((error) => {

                    console.log("ERROR:", error);
                }); 
        }

        this.editor.setEditable(false);
        // console.log("Save:", this.recommendation.content);
    },

    async onDelete() {

        if(this.recommendation.id < 0)
            return; // nothing to delete

        const ok = await this.$refs.confirmDialogue.show({
            title: 'Delete Recommendation?',
            message: 'Are you sure you want to delete? It cannot be undone.',
            okButton: 'Delete',
        });

        if (ok)
        {
            let id = this.recommendation.id;
            if(id != null && id >= 0)
            {
                let route = this.route + '/' + id;
                axios.delete(route)
                    .then((response) => {
                        
                        this.recommendation = {id:-1, content:''};
                        this.editor.commands.setContent(this.recommendation.content);
                        console.log('delete response:', response);
                    })
                    .catch((error) => {

                        console.log("ERROR:", error);
                    });
            }
        }            
    }
  },

  beforeDestroy() {
    this.editor.destroy()
  },

}
</script>

<style lang="scss" scoped>

</style>