<?php

// HealthController.cs
public class HealthController
{
    public HttpResponse GetHealth()
    {
        var healthData = new {
            status = "healthy",
            timestamp = DateTime.UtcNow,
            version = "1.0.0"
        };
        
        return new HttpResponse
        {
            StatusCode = 200,
            ContentType = "application/json",
            Body = JsonSerializer.Serialize(healthData)
        };
    }
}