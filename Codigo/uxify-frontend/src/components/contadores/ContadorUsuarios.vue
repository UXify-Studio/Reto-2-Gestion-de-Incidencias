<script>
import axios from 'axios';
import { API_BASE_URL } from '@/config.js';

export default {
    data() {
        return {
            usersTotal: []
        };
    },
    created() {
        axios.get(`${API_BASE_URL}/usersTotal`)
            .then(response => {
                this.usersTotal = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>