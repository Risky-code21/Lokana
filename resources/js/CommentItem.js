export default (initialContent) => ({
    isReplying: false,
    isEditing: false,
    editContent: initialContent,
    showReplies: false,
    replyTargetId: "",
    replyTargetName: "",

    setupReply(id, name) {
        this.isReplying = true;
        this.replyTargetId = id;
        this.replyTargetName = name;
        // Fokuskan ke input reply setelah dirender
        this.$nextTick(() => {
            this.$refs.replyInput.focus();
        });
    },

    scrollToTarget(id) {
        const el = document.getElementById("comment-" + id);
        console.log(el);
        if (el) {
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            el.classList.add(
                "bg-primary-light/20",
                "transition-colors",
                "duration-1000",
            );
            setTimeout(() => el.classList.remove("bg-primary-light/20"), 1000);
        }
    },

    submitReply(event) {
        const form = event.target;

        fetch(form.action, {
            method: "POST",
            body: new FormData(form),
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    form.reset();
                    this.isReplying = false;
                }
            })
            .catch((error) => console.error("Error:", error));
    },
});
