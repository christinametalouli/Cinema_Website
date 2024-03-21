package com.cinema.model;

import org.json.JSONObject;

public class User {

	private int userId;
	private String firstName;
	private String lastName;
	private String country;
	private String city;
	private String address;
	private String email;
	private String username;
	private String password;
	private int roleId;

	public User(int userId, String firstName, String lastName, String country, String city, String address,
			String email, String username, String password, int roleId) {
		this.userId = userId;
		this.firstName = firstName;
		this.lastName = lastName;
		this.country = country;
		this.city = city;
		this.address = address;
		this.email = email;
		this.username = username;
		this.password = password;
		this.roleId = roleId;
	}
	
	public void setUserId(int userId) {
	    this.userId = userId;
	}

	public void setFirstName(String firstName) {
	    this.firstName = firstName;
	}

	public void setLastName(String lastName) {
	    this.lastName = lastName;
	}

	public void setCountry(String country) {
	    this.country = country;
	}

	public void setCity(String city) {
	    this.city = city;
	}

	public void setAddress(String address) {
	    this.address = address;
	}

	public void setEmail(String email) {
	    this.email = email;
	}

	public void setUsername(String username) {
	    this.username = username;
	}

	public void setPassword(String password) {
	    this.password = password;
	}

	public void setRoleId(int roleId) {
	    this.roleId = roleId;
	}

	public int getUserId() {
		return userId;
	}

	public String getFirstName() {
		return firstName;
	}

	public String getLastName() {
		return lastName;
	}

	public String getCountry() {
		return country;
	}

	public String getCity() {
		return city;
	}

	public String getAddress() {
		return address;
	}

	public String getEmail() {
		return email;
	}

	public String getUsername() {
		return username;
	}

	public String getPassword() {
		return password;
	}

	public int getRoleId() {
		return roleId;
	}
	
	public JSONObject toJSONObject() {
		JSONObject jsonObject = new JSONObject();
		jsonObject.put("userId", userId);
		jsonObject.put("firstName", firstName);
		jsonObject.put("lastName", lastName);
		jsonObject.put("country", country);
		jsonObject.put("city", city);
		jsonObject.put("address", address);
		jsonObject.put("email", email);
		jsonObject.put("username", username);
		jsonObject.put("roleId", roleId);
		return jsonObject;
	}

	public String toJSON() {
		return toJSONObject().toString();
	}

	public static User jsonToUser(String json) {
	    JSONObject jsonObject = new JSONObject(json);
	    int id = 0; // assuming this is a new user and doesn't have an ID yet
	    String firstName = jsonObject.getString("firstName");
	    String lastName = jsonObject.getString("lastName");
	    String country = jsonObject.getString("country");
	    String city = jsonObject.getString("city");
	    String address = jsonObject.getString("address");
	    String email = jsonObject.getString("email");
	    String username = jsonObject.getString("username");
	    String password = jsonObject.getString("password");
	    int roleId = 1; // assuming this is a regular user and not an admin
	    User user = new User(id, firstName, lastName, country, city, address, email, username, password, roleId);
	    return user;
	}

}
