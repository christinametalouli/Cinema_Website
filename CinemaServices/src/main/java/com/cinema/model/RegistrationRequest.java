package com.cinema.model;

import org.json.JSONObject;

public class RegistrationRequest {
	private int requestId;
	private String firstName;
	private String lastName;
	private String country;
	private String city;
	private String address;
	private String email;
	private String username;
	private String password;
	private String status;

	public RegistrationRequest(int requestId, String firstName, String lastName, String country, String city,
			String address, String email, String username, String password, String status) {
		this.requestId = requestId;
		this.firstName = firstName;
		this.lastName = lastName;
		this.country = country;
		this.city = city;
		this.address = address;
		this.email = email;
		this.username = username;
		this.password = password;
		this.status = status;
	}

	public RegistrationRequest(User user) {
		this.requestId = -1;
		this.firstName = user.getFirstName();
		this.lastName = user.getLastName();
		this.country = user.getCountry();
		this.city = user.getCity();
		this.address = user.getAddress();
		this.email = user.getEmail();
		this.username = user.getUsername();
		this.password = user.getPassword();
		this.status = "pending";
	}

	public int getRequestId() {
		return requestId;
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

	public String getStatus() {
		return status;
	}

	public JSONObject toJSON() {
		JSONObject jsonObject = new JSONObject();
		jsonObject.put("requestId", requestId);
		jsonObject.put("firstName", firstName);
		jsonObject.put("lastName", lastName);
		jsonObject.put("country", country);
		jsonObject.put("city", city);
		jsonObject.put("address", address);
		jsonObject.put("email", email);
		jsonObject.put("username", username);
		jsonObject.put("status", status);
		return jsonObject;
	}
}
