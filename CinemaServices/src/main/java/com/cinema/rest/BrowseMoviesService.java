package com.cinema.rest;

import java.util.List;

import javax.ws.rs.*;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.json.JSONArray;
import org.json.JSONObject;

import com.cinema.dao.MovieDao;
import com.cinema.model.Movie;

@Path("/movies")
public class BrowseMoviesService {
  
  @GET
  @Produces("application/json")
  public Response getAllMovies() {
    
    try {
      // get a list of all movies from the database
      MovieDao movieDao = new MovieDao();
      List<Movie> movies = movieDao.getAllMovies();
      
      JSONArray jsonArray = new JSONArray();
      for (Movie movie : movies) {
        JSONObject jsonObject = new JSONObject();
        jsonObject.put("id", movie.getId());
        jsonObject.put("name", movie.getName());
        jsonObject.put("image_url", movie.getImageUrl());
        jsonArray.put(jsonObject);
      }
      
      return Response.status(200).entity(jsonArray.toString()).build();
      
    } catch (Exception e) {
      return Response.status(500).entity("Unable to retrieve movies. Error: " + e.getMessage()).build();
    }
  }
  
  @GET
  @Path("/{movieId}")
  @Produces(MediaType.APPLICATION_JSON)
  public Response getMovie(@PathParam("movieId") int movieId) {
    
    try {
      // get the movie with the specified ID from the database
      MovieDao movieDao = new MovieDao();
      Movie movie = movieDao.getMovieById(movieId);
      
      if (movie == null) {
        return Response.status(404).entity("Movie not found").build();
      }
      
      JSONObject jsonObject = new JSONObject();
      jsonObject.put("id", movie.getId());
      jsonObject.put("name", movie.getName());
      jsonObject.put("image_url", movie.getImageUrl());
      
      return Response.status(200).entity(jsonObject.toString()).build();
      
    } catch (Exception e) {
      return Response.status(500).entity("Unable to retrieve movie. Error: " + e.getMessage()).build();
    }
  }
}

