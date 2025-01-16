<script>
import axios from 'axios';

export default {
    data() {
        return {
            usersTotal: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/usersTotal')
            .then(response => {
                this.usersTotal = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
};
</script>