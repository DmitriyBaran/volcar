<template>
    <div>
        <form @submit.prevent="submitReview">
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea v-model="review.text" class="form-control" id="review" maxlength="1000"></textarea>
            </div>
            <div class="form-group">
                <input type="file" @change="handleFilesUpload" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h2>Reviews</h2>
        <ul class="list-group">
            <li v-for="review in reviews" :key="review.id" class="list-group-item">
                <strong>{{ review.user.name }}</strong> ({{ review.created_at }}):
                <p>{{ review.text }}</p>
                <div v-if="review.images.length > 0">
                    <strong>Images:</strong>
                    <ul class="list-inline">
                        <li v-for="image in review.images" :key="image.id" class="list-inline-item">
                            <img :src="'/storage/app/' + image.path" alt="Review Image" class="img-thumbnail" width="100">
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            review: {
                text: '',
                images: []
            },
            reviews: []
        }
    },
    mounted() {
        this.getReviews();
    },
    methods: {
        getReviews() {
            axios.get('/show', { params: { timestamp: new Date().getTime() } })
                .then(response => {
                    this.reviews = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleFilesUpload(event) {
            this.review.images = Array.from(event.target.files);
        },
        submitReview() {
            let formData = new FormData();
            formData.append('text', this.review.text);
            this.review.images.forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });

            axios.post('/reviews', formData)
                .then((response) => {
                    this.getReviews();
                    this.review.text = '';
                    this.review.images = [];
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
};
</script>
