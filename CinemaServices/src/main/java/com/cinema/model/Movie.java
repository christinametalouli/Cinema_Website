package com.cinema.model;

import org.json.JSONObject;

public class Movie {
	  
  private int movieId;
  private String name;
  private String imageUrl;
  
  public Movie(int movieId, String name, String imageUrl) {
    this.movieId = movieId;
    this.name = name;
    this.imageUrl = imageUrl;
  }
  
  public int getId() {
    return movieId;
  }
  
  public void setId(int movieId) {
    this.movieId = movieId;
  }
  
  public String getName() {
    return name;
  }
  
  public void setName(String name) {
    this.name = name;
  }
  
  public String getImageUrl() {
    return imageUrl;
  }
  
  public void setImageUrl(String imageUrl) {
    this.imageUrl = imageUrl;
  }
  
  public static Movie jsonToMovie(String json) {
	    JSONObject jsonObject = new JSONObject(json);
	    int id = 0;
	    String name = jsonObject.getString("name");
	    String imageUrl = jsonObject.getString("image_url");
	    return new Movie(id, name, imageUrl);
	}
  
public JSONObject toJSON() {
    JSONObject jsonObject = new JSONObject();
    jsonObject.put("id", getId());
    jsonObject.put("name", getName());
    jsonObject.put("image_url", getImageUrl());
    return jsonObject;
}
}
