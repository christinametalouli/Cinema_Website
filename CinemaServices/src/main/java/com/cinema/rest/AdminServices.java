package com.cinema.rest;

import javax.ws.rs.*;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.json.JSONArray;
import org.json.JSONObject;

import java.sql.SQLException;
import java.util.List;

import com.cinema.dao.MovieDao;
import com.cinema.dao.RegistrationRequestDao;
import com.cinema.dao.UserDao;
import com.cinema.model.Movie;
import com.cinema.model.RegistrationRequest;
import com.cinema.model.User;

@Path("/admin")
public class AdminServices {

	private RegistrationRequestDao registrationRequestDao;
	private UserDao userDao;

	public AdminServices() {
	    try {
			this.registrationRequestDao = new RegistrationRequestDao();
			this.userDao = new UserDao();
		} catch (ClassNotFoundException | SQLException e) {
			e.printStackTrace();
		}
	}
	
	// REGISTRATION
	
	@GET
	@Path("/registration_requests")
	@Produces(MediaType.APPLICATION_JSON)
	public Response getAllRegistrationRequests() {
	    try {
	        List<RegistrationRequest> requests = registrationRequestDao.getAllRequests();
	        JSONArray jsonArray = new JSONArray();
	        for (RegistrationRequest request : requests) {
	            JSONObject jsonObject = request.toJSON();
	            jsonArray.put(jsonObject);
	        }
	        return Response.ok(jsonArray.toString()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to retrieve registration requests. Error: " + e.getMessage()).build();
	    }
	}
	
	@PUT
	@Path("/registration_requests/approve/{requestId}")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	public Response approveRegistrationRequest(@PathParam("requestId") int requestId, String body) {
		JSONObject jsonObject = new JSONObject(body);
	    String role = jsonObject.getString("role");
	    
	    if (role == null || role.isEmpty()) {
	    	return Response.status(404).entity("Undefined role").build();
	    }
		
		try {
	        RegistrationRequestDao registrationRequestDao = new RegistrationRequestDao();
	        RegistrationRequest registrationRequest = registrationRequestDao.findById(requestId);
	        
	        if (registrationRequest == null) {
	            return Response.status(404).entity("Registration request not found").build();
	        }

	        User user = new User(0, registrationRequest.getFirstName(), registrationRequest.getLastName(), registrationRequest.getCountry(), registrationRequest.getCity(), registrationRequest.getAddress(), registrationRequest.getEmail(), registrationRequest.getUsername(), registrationRequest.getPassword(), role.equals("admin") ? 2 : 1);
	        System.out.println(user.toJSON());
	        userDao.create(user);

	        registrationRequestDao.deleteRegistrationRequest(requestId);

	        return Response.status(200).entity(user.toJSON()).build();
	    } catch (Exception e) {
	    	e.printStackTrace();
	        return Response.status(500).entity("Unable to approve registration request. Error: " + e.getMessage()).build();
	    }
	}


	@DELETE
	@Path("/registration_requests/deny/{requestId}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response denyRegistrationRequest(@PathParam("requestId") int requestId) {
	    try {
	        RegistrationRequestDao registrationRequestDao = new RegistrationRequestDao();
	        RegistrationRequest registrationRequest = registrationRequestDao.findById(requestId);

	        if (registrationRequest == null) {
	            return Response.status(404).entity("Registration request not found").build();
	        }

	        registrationRequestDao.deleteRegistrationRequest(requestId);

	        return Response.status(200).entity("Registration request denied").build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to deny registration request. Error: " + e.getMessage()).build();
	    }
	}

	// USER MANAGEMENT
	
	@GET
	@Path("/users")
	@Produces(MediaType.APPLICATION_JSON)
	public Response getAllUsers() {
	    try {
	        List<User> users = userDao.getAll();
	        JSONArray jsonArray = new JSONArray();
	        for (User user : users) {
	            jsonArray.put(user.toJSONObject());
	        }
	        return Response.status(200).entity(jsonArray.toString()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to retrieve users. Error: " + e.getMessage()).build();
	    }
	}

	@GET
	@Path("/users/{userId}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response getUser(@PathParam("userId") int userId) {
	    try {
	        User user = userDao.findById(userId);
	        if (user == null) {
	            return Response.status(404).entity("User not found").build();
	        }
	        return Response.status(200).entity(user.toJSON()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to retrieve user. Error: " + e.getMessage()).build();
	    }
	}

	@PUT
	@Path("/users/{userId}")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateUser(@PathParam("userId") int userId, String body) {
		User user = User.jsonToUser(body);
		
	    try {
	        User existingUser = userDao.findById(userId);
	        if (existingUser == null) {
	            return Response.status(404).entity("User not found").build();
	        }
	        existingUser.setFirstName(user.getFirstName());
	        existingUser.setLastName(user.getLastName());
	        existingUser.setCountry(user.getCountry());
	        existingUser.setCity(user.getCity());
	        existingUser.setAddress(user.getAddress());
	        existingUser.setEmail(user.getEmail());
	        existingUser.setUsername(user.getUsername());
	        existingUser.setPassword(user.getPassword());
	        userDao.update(existingUser);
	        return Response.status(200).entity(existingUser.toJSON().toString()).build();
	    } catch (Exception e) {
	    	e.printStackTrace();
	        return Response.status(500).entity("Unable to update user. Error: " + e.getMessage()).build();
	    }
	}

	@DELETE
	@Path("/users/{userId}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteUser(@PathParam("userId") int userId) {
	    try {
	        User existingUser = userDao.findById(userId);
	        if (existingUser == null) {
	            return Response.status(404).entity("User not found").build();
	        }
	        userDao.delete(userId);
	        return Response.status(200).entity(existingUser.toJSON().toString()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to delete user. Error: " + e.getMessage()).build();
	    }
	}

	
	// Movies
	
	@POST
	@Path("/movies/new")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	public Response addMovie(String body) {
	    // Parse the request body as a JSON object
	    JSONObject json = new JSONObject(body);

	    // Extract the movie properties from the JSON object
	    String name = json.getString("name");
	    String imageUrl = json.getString("image_url");

	    // Create a new movie object
	    Movie movie = new Movie(0, name, imageUrl);

	    try {
	        // Add the movie to the database
	        MovieDao movieDao = new MovieDao();
	        movieDao.addMovie(movie);

	        // Return the new movie object as JSON
	        return Response.status(201).entity(movie.toJSON().toString()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to add movie. Error: " + e.getMessage()).build();
	    }
	}

	
	@PUT
	@Path("/movies/{movieId}")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	public Response updateMovie(@PathParam("movieId") int movieId, String body) {
	    Movie updatedMovie = Movie.jsonToMovie(body);
	    
	    if (updatedMovie == null) {
	    	return Response.status(500).entity("Unable to update movie. Invalid data").build();
	    }
		
		try {
	        MovieDao movieDao = new MovieDao();
	        Movie movie = movieDao.getMovieById(movieId);
	        
	        if (movie == null) {
	            return Response.status(404).entity("Movie not found").build();
	        }
	        
	        // Update the movie details
	        movie.setName(updatedMovie.getName());
	        movie.setImageUrl(updatedMovie.getImageUrl());
	        movieDao.updateMovie(movie);
	        
	        
	        return Response.status(200).entity(movie.toJSON().toString()).build();
	        
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to update movie. Error: " + e.getMessage()).build();
	    }
	}

	@DELETE
	@Path("/movies/{movieId}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response deleteMovie(@PathParam("movieId") int movieId) {
	    try {
	        MovieDao movieDao = new MovieDao();
	        Movie movie = movieDao.getMovieById(movieId);

	        if (movie == null) {
	            return Response.status(404).entity("Movie not found").build();
	        }

	        movieDao.deleteMovie(movieId);

	        return Response.status(200).entity(movie.toJSON().toString()).build();

	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to delete movie. Error: " + e.getMessage()).build();
	    }
	}
}
