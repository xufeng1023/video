<template>
	<div class="card border-info mb-3" style="max-width: 20rem;">
  		<div class="card-header">Card Info</div>
  		<div class="card-body text-info">
    		<form @submit.prevent="pay">
    			<div class="form-group">
			    	<label for="card-number">Card Number</label>
			    	<input type="text" class="form-control" id="card-number" placeholder="Card number">
			  	</div>
			  	<div class="row">
				    <div class="col">
				      	<div class="form-group">
					    	<label for="expiration">Expiration</label>
					    	<input type="text" class="form-control" id="expiration" placeholder="Expiration">
					  	</div>
				    </div>
				    <div class="col">
				      	<div class="form-group">
					    	<label for="cvc">CVC</label>
					    	<input type="text" class="form-control" id="cvc" placeholder="CVC">
					  	</div>
				    </div>
			  	</div>
				<button class="btn btn-primary" type="submit">Pay</button>
			</form>
  		</div>
	</div>
</template>

<script>
	axios.defaults.headers.common['X-CSRF-TOKEN'] = '';
	axios.defaults.headers.common['Authorization'] = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI5Y2E1NTM2NWViNjczZDIwZDhmZmIyMWE3MzQ1MWM0MDY4NDJiMGY0ZWRlNDc0ZmU0ODhjODVlOTdjZDQzNmI1MDY4NDIzODIzOTg5M2NlIn0.eyJhdWQiOiIyIiwianRpIjoiMjljYTU1MzY1ZWI2NzNkMjBkOGZmYjIxYTczNDUxYzQwNjg0MmIwZjRlZGU0NzRmZTQ4OGM4NWU5N2NkNDM2YjUwNjg0MjM4MjM5ODkzY2UiLCJpYXQiOjE1MDU2ODIyMjEsIm5iZiI6MTUwNTY4MjIyMSwiZXhwIjoxNTM3MjE4MjIxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.KhJGAl7Je7fSWzKTeTz2rf9g58-W5YSVoUA2L0PMaQPPJlFD1h7ETj1e73zLZ74bGofYBG46uZT0iyWpiBkPastx96tcS8oKOM2hNirqRHfiqZGBSpAIb0N-JDJCdSTHGKFeROQK3gc_FshuD5t-aeZ7c_wm8oahxlA4hkU3s3gVFkci5IpeAQsB6w5MrcBlXUOzfD-D_r1dTyNDaFkGHYF07LsGOW-Iu7QiJfB5n6W7NY-_z47v1Ca9GN_QOzT5Mf6UAkFshBvgDTNFVDoWRzYxF4VTCtyMGrAIpp5dTUCLAE_rImokjUsybSPgg2TtlwCbwI3OUzp6duZ5xt9f6cX6t5kGxbqSWzP7ophrGBIimQ6s91Tphlo3AYLqx-1FLj0FOe6yea1JgiQPnOciKq0IcHypDrVsvGLDqTIBruvv8kU4BrsCVK9sUL0wkk2YFAeKku1qwUQzH4GD7YPt-dwymC2RJHELaKcq0VqV15pkJ1K4Ex6PKR6iCgfxfuVbTYl960AQs8rGuz-BYLM-b6KDaglS6mFNNt505CjMclCTUdczbBdGUwKqJfZP5xX-u80fHYGU9kpDIVhzq_QjTvX4uHDGPO5T13KSHVl1Zwa23RdLki8NsLpJvDtCPou_ljz_wpFhE8MRpy-02ZEeZteozX-sCbEa78Wp_P_Iu1E';

	export default {
		props: ['user'],
		methods: {
			pay() {
				axios.post('http://127.0.0.2:8000/api/subscribe/' + this.user.id, 
					{apiToken: this.user.api_token}
				).then(r => {
					console.log(r.data);
				});
			}
		}
	}
</script>
