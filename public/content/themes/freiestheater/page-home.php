<div ng-controller="HomeCtrl">
     <div ng-repeat="post in posts">
		  <h1>{{post.post_title}}</h1>
          <p>{{post.post_content}}</p>
     </div>

<form name="login" novalidate>
     <div>
		<label for="email">Email</label>
		<input type="email" name="email" ng-model="user.email" required/>
		<span ng-show="login.email.$error.required && submitted">please enter email</span>
		<span ng-show="login.$error.email && submitted">email is invalid</span>
	 </div>
	 <div>
		<label for="password">Password</label>
		<input type="password" name="password" ng-model="user.password" required/>
        <span ng-show="login.password.$error.required && submitted">please enter password</span>
	 </div>
	 <button type="submit" ng-click="submitLogin(login)">login</button>
</form>
     </div>
     