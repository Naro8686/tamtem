const messages = {
  methods: {
    showError(message) {
      this.$message({
        position: "top-right",
        message: message,
        type: "error",
        showClose: true
      });
    },
    showSuccess(message) {
      this.$message({
        position: "top-right",
        message: message,
        type: "success",
        showClose: true
      });
    }
  }
};
export default messages;
