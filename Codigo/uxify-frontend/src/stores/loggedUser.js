import { defineStore } from "pinia";
import axios from "axios";
import { API_BASE_URL } from "@/config.js";

export const useLoggedUser = defineStore("loggedUser", {
    state: () => ({
        usersName: null,
    }),
    actions: {
        async fetchUsersTotal() {
            try {
                const token = sessionStorage.getItem("token");
                if (!token) {
                    throw new Error("Token not found");
                }

                const response = await axios.get(`${API_BASE_URL}/auth/me`, {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                    },
                });

                this.userName = response.data.name;
            } catch (error) {
                console.error("Error al obtener usuarios:", error);
            }
        },
    },
});
