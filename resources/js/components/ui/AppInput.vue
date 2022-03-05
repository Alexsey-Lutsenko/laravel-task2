<template>
    <input :value="modelValue" @input="updateInput" type="text" />
</template>

<script>
export default {
    name: "AppInput",
    props: {
        modelValue: [String, Number],
    },
    setup(props, { emit }) {
        return {
            updateInput: (event) => {
                emit("update:modelValue", event.target.value);
            },
        };
    },
};
</script>

<style scoped lang="scss">
input {
    width: 100%;
    padding: 0.375rem 0.75rem;
    background: none;
    border: none;
    border-bottom: 1px solid var(--app-color-grey);
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

input:focus {
    outline: 0;
    box-shadow: 0px 3px 2px -3px rgba(0, 0, 0, 0.3);
}
</style>
