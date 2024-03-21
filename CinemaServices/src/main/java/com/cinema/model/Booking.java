package com.cinema.model;

import java.sql.Timestamp;
import org.json.JSONObject;

public class Booking {
	private int id;
	private int userId;
	private int movieId;
	private String email;
	private Timestamp bookingDate;

	public Booking(int id, int userId, int movieId, String email, Timestamp bookingDate) {
		this.id = id;
		this.userId = userId;
		this.movieId = movieId;
		this.email = email;
		this.bookingDate = bookingDate;
	}

	public int getId() {
		return id;
	}

	public int getUserId() {
		return userId;
	}

	public int getMovieId() {
		return movieId;
	}
	
	public String getEmail() {
		return this.email;
	}

	public Timestamp getBookingDate() {
		return bookingDate;
	}

	public JSONObject toJSON() {
		JSONObject jsonObject = new JSONObject();
		jsonObject.put("id", id);
		jsonObject.put("user_id", userId);
		jsonObject.put("movie_id", movieId);
		jsonObject.put("email", email);
		jsonObject.put("booking_date", bookingDate.toString());
		return jsonObject;
	}

	public static Booking fromJSON(String jsonString) {
		JSONObject jsonObject = new JSONObject(jsonString);
		int id = 0;
		
		if (jsonObject.has("id")) {
			id = jsonObject.getInt("id");
		}
		int userId = jsonObject.getInt("user_id");
		int movieId = jsonObject.getInt("movie_id");
		String email = jsonObject.getString("email");
		Timestamp bookingDate = Timestamp.valueOf(jsonObject.getString("booking_date"));

		return new Booking(id, userId, movieId, email, bookingDate);
	}
}
