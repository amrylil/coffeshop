<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { route } from "ziggy-js";

interface User {
    name: string;
    email: string;
    profile_photo: string | null;
    gender: "male" | "female" | null;
    address: string | null;
    phone: string | null;
    birth_date: string | null;
}

const props = defineProps<{
    user: User;
    errors: Object;
}>();

const photoPreview = ref<string | null>(null);
const showPasswordSection = ref<boolean>(false);

const form = useForm({
    _method: "PATCH",
    name: props.user.name,
    gender: props.user.gender,
    address: props.user.address,
    phone: props.user.phone,
    birth_date: props.user.birth_date,
    profile_photo: null as File | null,
    password: "",
    password_confirmation: "",
});

const selectNewPhoto = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.profile_photo = file;

        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const updateProfile = () => {
    form.post(route("profile.update"), {
        preserveScroll: true,
        onSuccess: () => {
            // Clear password fields on successful update
            form.reset("password", "password_confirmation");
        },
    });
};

const profilePhotoUrl = () => {
    if (photoPreview.value) {
        return photoPreview.value;
    }
    if (props.user.profile_photo) {
        return `/storage/${props.user.profile_photo}`;
    }
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(
        props.user.name
    )}&color=ffffff&background=6B4226`;
};
</script>

<template>
    <AppLayout title="Edit Profile">
        <div class="min-h-screen pt-14" style="background-color: #f5f0e8">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <div
                    class="bg-white border-4 border-coklat"
                    style="
                        box-shadow: 8px 8px 0px #8b4513, 16px 16px 0px #d2b48c;
                    "
                >
                    <!-- Coffee Shop Header -->
                    <div class="bg-coklat text-white p-6 text-center">
                        <div class="text-center mb-8 space-y-3">
                            <h2 class="text-5xl font-serif italic text-lunen">
                                Profile
                            </h2>
                            <div class="flex justify-center items-center">
                                <div class="h-px w-16 bg-[#e6dbd1]"></div>
                                <span class="mx-4">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#e6dbd1"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            d="M17 8h1a4 4 0 1 1 0 8h-1"
                                        ></path>
                                        <path
                                            d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"
                                        ></path>
                                        <line
                                            x1="6"
                                            y1="2"
                                            x2="6"
                                            y2="4"
                                        ></line>
                                        <line
                                            x1="10"
                                            y1="2"
                                            x2="10"
                                            y2="4"
                                        ></line>
                                        <line
                                            x1="14"
                                            y1="2"
                                            x2="14"
                                            y2="4"
                                        ></line>
                                    </svg>
                                </span>
                                <div class="h-px w-16 bg-[#e6dbd1]"></div>
                            </div>
                            <p
                                class="text-xl font-light text-lunen max-w-3xl mx-auto"
                            >
                                Welcome to your profile page. Here you can view
                                your
                                <span class="font-serif italic text-[#e6dbd1]"
                                    >Profile</span
                                >
                            </p>
                        </div>
                    </div>

                    <form @submit.prevent="updateProfile" class="p-8">
                        <!-- Error Messages -->
                        <div
                            v-if="Object.keys(errors).length > 0"
                            class="mb-8 p-5 bg-red-100 text-red-800 border-4 border-red-600 max-w-4xl mx-auto"
                            style="box-shadow: 4px 4px 0px #dc2626"
                        >
                            <div class="flex items-center">
                                <svg
                                    class="w-6 h-6 mr-3"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <strong class="font-bold text-lg"
                                    >Please review the following errors:</strong
                                >
                            </div>
                            <ul
                                class="mt-4 list-disc list-inside text-sm space-y-2 ml-4"
                            >
                                <li
                                    v-for="(error, key) in errors"
                                    :key="key"
                                    class="font-medium"
                                >
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <div class="max-w-6xl mx-auto">
                            <!-- Left Column - Profile Photo & Personal Info -->
                            <div class="grid lg:grid-cols-3 gap-8">
                                <!-- Profile Photo Upload -->
                                <div class="lg:col-span-1">
                                    <div
                                        class="bg-amber-50 p-8 border-4 border-amber-800"
                                        style="box-shadow: 4px 4px 0px #92400e"
                                    >
                                        <h3
                                            class="text-xl font-bold text-amber-900 mb-6 text-center border-b-2 border-amber-800 pb-3"
                                        >
                                            ☕ PROFILE PHOTO ☕
                                        </h3>
                                        <div class="text-center mb-6">
                                            <div
                                                class="inline-block p-1 bg-amber-900"
                                            >
                                                <img
                                                    :src="profilePhotoUrl()"
                                                    :alt="user.name"
                                                    class="w-36 h-36 border-4 border-white object-cover"
                                                />
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <input
                                                type="file"
                                                @change="selectNewPhoto"
                                                accept="image/*"
                                                class="block w-full text-sm text-amber-900 file:mr-4 file:py-3 file:px-6 file:border-0 file:bg-amber-800 file:text-white file:font-bold hover:file:bg-amber-900 file:cursor-pointer cursor-pointer"
                                            />
                                        </div>
                                        <p
                                            class="text-xs text-amber-700 mt-3 text-center font-semibold"
                                        >
                                            JPG • PNG • GIF
                                        </p>
                                    </div>
                                </div>

                                <!-- Personal Information Form -->
                                <div class="lg:col-span-2">
                                    <div
                                        class="bg-amber-50 p-8 border-4 border-amber-800"
                                        style="box-shadow: 4px 4px 0px #92400e"
                                    >
                                        <h3
                                            class="text-2xl font-bold text-amber-900 mb-8 flex items-center justify-center border-b-2 border-amber-800 pb-3"
                                        >
                                            <svg
                                                class="w-6 h-6 mr-3"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            PERSONAL INFORMATION
                                        </h3>

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <!-- Name -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Full Name *
                                                </label>
                                                <input
                                                    v-model="form.name"
                                                    type="text"
                                                    required
                                                    class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                    style="
                                                        box-shadow: 2px 2px 0px
                                                            #92400e;
                                                    "
                                                />
                                            </div>

                                            <!-- Email (readonly) -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Email Address
                                                </label>
                                                <input
                                                    type="email"
                                                    :value="user.email"
                                                    readonly
                                                    class="w-full p-4 bg-stone-200 border-3 border-stone-400 text-stone-700 cursor-not-allowed font-semibold text-lg"
                                                />
                                                <p
                                                    class="text-xs text-amber-700 mt-2 font-bold"
                                                >
                                                    ⚠ Email cannot be modified
                                                </p>
                                            </div>

                                            <!-- Gender -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Gender
                                                </label>
                                                <select
                                                    v-model="form.gender"
                                                    class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                    style="
                                                        box-shadow: 2px 2px 0px
                                                            #92400e;
                                                    "
                                                >
                                                    <option value="">
                                                        Choose Gender
                                                    </option>
                                                    <option value="male">
                                                        Male
                                                    </option>
                                                    <option value="female">
                                                        Female
                                                    </option>
                                                </select>
                                            </div>

                                            <!-- Phone -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Phone Number
                                                </label>
                                                <input
                                                    v-model="form.phone"
                                                    type="text"
                                                    class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                    placeholder="e.g., +62 812 3456 7890"
                                                    style="
                                                        box-shadow: 2px 2px 0px
                                                            #92400e;
                                                    "
                                                />
                                            </div>

                                            <!-- Birth Date -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Date of Birth
                                                </label>
                                                <input
                                                    v-model="form.birth_date"
                                                    type="date"
                                                    class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                    style="
                                                        box-shadow: 2px 2px 0px
                                                            #92400e;
                                                    "
                                                />
                                            </div>

                                            <!-- Address -->
                                            <div>
                                                <label
                                                    class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                                >
                                                    Address
                                                </label>
                                                <textarea
                                                    v-model="form.address"
                                                    rows="4"
                                                    class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                    placeholder="Enter your complete address"
                                                    style="
                                                        box-shadow: 2px 2px 0px
                                                            #92400e;
                                                    "
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section - Collapsible -->
                            <div class="mt-8">
                                <button
                                    type="button"
                                    @click="
                                        showPasswordSection =
                                            !showPasswordSection
                                    "
                                    class="flex items-center justify-center w-full p-5 bg-coklat text-white font-bold transition-colors duration-200 text-lg"
                                    style="box-shadow: 4px 4px 0px #461901"
                                >
                                    <svg
                                        class="w-6 h-6 mr-3"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    {{
                                        showPasswordSection
                                            ? "HIDE PASSWORD SECTION"
                                            : "CHANGE PASSWORD"
                                    }}
                                    <svg
                                        :class="[
                                            'w-5 h-5 ml-3 transition-transform duration-200',
                                            showPasswordSection
                                                ? 'rotate-180'
                                                : '',
                                        ]"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>

                                <div
                                    v-show="showPasswordSection"
                                    class="bg-stone-100 p-8 border-4 border-amber-800 border-t-0"
                                    style="box-shadow: 4px 4px 0px #92400e"
                                >
                                    <div
                                        class="bg-amber-100 p-4 border-2 border-amber-600 mb-6"
                                    >
                                        <p
                                            class="text-amber-800 text-sm font-bold text-center"
                                        >
                                            ⚠ Leave blank if you don't want to
                                            change your password ⚠
                                        </p>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div>
                                            <label
                                                class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                            >
                                                New Password
                                            </label>
                                            <input
                                                v-model="form.password"
                                                type="password"
                                                class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                placeholder="Enter new password"
                                                style="
                                                    box-shadow: 2px 2px 0px
                                                        #92400e;
                                                "
                                            />
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-bold text-amber-900 mb-3 uppercase tracking-wide"
                                            >
                                                Confirm New Password
                                            </label>
                                            <input
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                type="password"
                                                class="w-full p-4 bg-white border-3 border-amber-600 focus:border-amber-900 focus:outline-none font-semibold text-amber-900 text-lg"
                                                placeholder="Confirm new password"
                                                style="
                                                    box-shadow: 2px 2px 0px
                                                        #92400e;
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="w-full bg-coklat text-white font-bold py-6 px-8 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center justify-center text-xl tracking-wide"
                                    style="box-shadow: 6px 6px 0px #451a03"
                                >
                                    <svg
                                        v-if="!form.processing"
                                        class="w-6 h-6 mr-3"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    <svg
                                        v-else
                                        class="animate-spin -ml-1 mr-3 h-6 w-6 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    {{
                                        form.processing
                                            ? "UPDATING PROFILE..."
                                            : "UPDATE PROFILE"
                                    }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
