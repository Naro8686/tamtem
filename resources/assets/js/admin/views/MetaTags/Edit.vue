<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="row box-body" @submit="saveForm">
        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['title'] ? 'has-error' : ''
              ]"
            >
              <label for="title">Meta Title</label>
              <input
                  v-model="metaTag.title"
                  type="text"
                  class="form-control"
                  id="title"
                  placeholder="Введите Meta Title"
              />
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['description'] ? 'has-error' : ''
              ]"
            >
              <label for="description">Meta Description</label>
              <textarea class="form-control" id="description" v-model="metaTag.description"></textarea>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['keywords'] ? 'has-error' : ''
              ]"
            >
              <label for="description">Meta keywords</label>
              <textarea class="form-control" id="keywords" v-model="metaTag.keywords"></textarea>
            </div>
          </div>
        </div>
        <div class="col-md-12 frm-buttons text-center">
          <div class="btn-group">
            <input
                v-if="this.$root.profile.permissions.metatags.edit"
                class="btn btn-default"
                type="submit"
                value="Обновить"
            />
<!--            <input-->
<!--                v-if="this.$root.profile.permissions.metatags.delete"-->
<!--                class="btn btn-danger"-->
<!--                type="button"-->
<!--                @click="deleteMetaTag"-->
<!--                value="Удалить"-->
<!--            />-->
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import ViewMixins from "../../mixins/view";
export default {
  name: "Edit",
  mixins: [ViewMixins],
  data() {
    return {
      metaTag: {
        page_slug: "",
        page: "",
        title: "",
        description: "",
        keywords: "",
      },
    };
  },
  mounted() {
    this.getMetaTag();
  },
  methods: {
    getMetaTag() {
      axios
          .get("/admin/api/metatags/" + this.$route.params.id)
          .then((resp) => {
            this.metaTag = resp.data.data;
          })
          .catch(this.handleErrorResponse);
    },
    saveForm(event) {
      event.preventDefault();

      axios
          .patch("/admin/api/metatags/" + this.$route.params.id, this.metaTag)
          .then((resp) => {
            this.messageSaved();
            this.$router.push({ name: "metatags" });
          })
          .catch(this.handleErrorResponse);
    },
    deleteMetaTag() {
      axios.delete("/admin/api/metatags/" + this.$route.params.id).then((resp) => {
        this.$router.push({ name: "metatags" });
        this.messageDeleted();
      });
    },

  }
}
</script>

<style scoped>

</style>