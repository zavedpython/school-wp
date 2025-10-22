#!/bin/bash

echo "🚀 Deploying WordPress School Website..."

# Navigate to WordPress directory
cd "$(dirname "$0")"

# Backup original wp-config.php
if [ -f "wp-config.php" ]; then
    cp wp-config.php wp-config-backup.php
    echo "✅ Backed up original wp-config.php"
fi

# Use Docker configuration
cp wp-config-docker.php wp-config.php
echo "✅ Applied Docker configuration"

# Stop existing containers
docker-compose down

# Build and start containers
echo "🐳 Starting Docker containers..."
docker-compose up -d --build

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to initialize..."
sleep 30

# Check container status
echo "📊 Container Status:"
docker-compose ps

echo ""
echo "🎉 WordPress deployment complete!"
echo "📱 Access your website at: http://localhost:8080"
echo "🔧 Admin credentials: admin / admin123"
echo ""
echo "📝 To stop containers: docker-compose down"
echo "📝 To view logs: docker-compose logs -f"
