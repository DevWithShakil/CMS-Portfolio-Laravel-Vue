<template>
    <div class="w-full bg-white shadow p-4 flex justify-end">
        <button
            @click="logout"
            class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"
        >
            Logout
        </button>
    </div>
</template>

<script setup>
const logout = () => {
    alert("Logout clicked!");
};
</script>
