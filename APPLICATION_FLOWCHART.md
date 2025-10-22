# Application Flow Chart - NAF Public School Website

## 🔄 System Overview Flow

```mermaid
graph TB
    A[User Access] --> B{User Type}
    B -->|Public User| C[Public Website]
    B -->|Admin User| D[Admin Panel]
    
    C --> E[Homepage]
    C --> F[Admission]
    C --> G[Contact]
    C --> H[Gallery]
    C --> I[About Pages]
    
    D --> J[Login]
    J --> K{Authentication}
    K -->|Success| L[Dashboard]
    K -->|Fail| J
    
    L --> M[Content Management]
    L --> N[File Management]
    L --> O[Settings]
```

## 🏠 Public Website Flow

### Homepage Navigation Flow
```mermaid
graph TD
    A[Homepage Load] --> B[Header with Contact Info]
    B --> C[Hero Section]
    C --> D[Quick Links Section]
    D --> E[About Section]
    E --> F[Notice Board]
    F --> G[Footer with Map]
    
    D --> H{User Clicks}
    H -->|Admission| I[Admission Page]
    H -->|Fee Structure| J[Fee Page]
    H -->|Faculty| K[Faculty Page]
    H -->|Gallery| L[Gallery Page]
    
    I --> M[Admission Form]
    M --> N[File Upload]
    N --> O[Form Submission]
    O --> P[Success Message]
```

### Contact System Flow
```mermaid
graph TD
    A[Contact Page] --> B[Contact Form]
    A --> C[Contact Information]
    A --> D[Google Maps]
    
    B --> E[Form Fields]
    E --> F[Name, Email, Phone]
    F --> G[Subject, Message]
    G --> H[Form Validation]
    H -->|Valid| I[Send Email]
    H -->|Invalid| J[Show Errors]
    I --> K[Success Message]
    J --> E
```

### Gallery System Flow
```mermaid
graph TD
    A[Gallery Page] --> B[Filter Buttons]
    A --> C[Image Grid]
    
    B --> D{Filter Selection}
    D -->|All| E[Show All Images]
    D -->|Events| F[Show Event Images]
    D -->|Sports| G[Show Sports Images]
    D -->|Academic| H[Show Academic Images]
    
    C --> I[Image Click]
    I --> J[Image Modal/Viewer]
    J --> K[Navigation Controls]
    K --> L[Previous/Next Image]
```

## 🔐 Admin Panel Flow

### Authentication Flow
```mermaid
graph TD
    A[Admin Access] --> B[Login Page]
    B --> C[Enter Credentials]
    C --> D[Form Validation]
    D -->|Valid| E[Check User Database]
    D -->|Invalid| F[Show Validation Errors]
    
    E --> G{User Exists?}
    G -->|Yes| H{Password Correct?}
    G -->|No| I[Invalid User Error]
    
    H -->|Yes| J[Create Session]
    H -->|No| K[Invalid Password Error]
    
    J --> L[Redirect to Dashboard]
    I --> B
    K --> B
    F --> B
```

### Dashboard Flow
```mermaid
graph TD
    A[Dashboard Load] --> B[Check Authentication]
    B -->|Authenticated| C[Load Dashboard]
    B -->|Not Authenticated| D[Redirect to Login]
    
    C --> E[Display Statistics]
    C --> F[Recent Activities]
    C --> G[Quick Actions]
    
    G --> H{Admin Action}
    H -->|Gallery| I[Gallery Management]
    H -->|Notices| J[Notice Management]
    H -->|Settings| K[School Settings]
    H -->|Principal| L[Principal Management]
```

### Content Management Flow
```mermaid
graph TD
    A[Content Management] --> B{Content Type}
    
    B -->|Gallery| C[Gallery Management]
    B -->|Notices| D[Notice Management]
    B -->|Principal| E[Principal Management]
    B -->|Settings| F[School Settings]
    
    C --> G[Upload Images]
    G --> H[Image Processing]
    H --> I[Save to Gallery]
    
    D --> J[Create/Edit Notice]
    J --> K[Notice Form]
    K --> L[Save Notice]
    
    E --> M[Update Principal Info]
    M --> N[Upload Photo]
    N --> O[Save Principal Data]
    
    F --> P[Update School Info]
    P --> Q[Save Settings]
```

## 📁 File Upload Flow

### Image Upload Process
```mermaid
graph TD
    A[File Selection] --> B[File Validation]
    B --> C{Valid File?}
    C -->|No| D[Show Error Message]
    C -->|Yes| E[Check File Size]
    
    E --> F{Size OK?}
    F -->|No| G[File Too Large Error]
    F -->|Yes| H[Check File Type]
    
    H --> I{Type Allowed?}
    I -->|No| J[Invalid Type Error]
    I -->|Yes| K[Generate Unique Name]
    
    K --> L[Move to Upload Directory]
    L --> M{Upload Success?}
    M -->|No| N[Upload Failed Error]
    M -->|Yes| O[Update Database]
    O --> P[Success Message]
```

### Document Upload Flow
```mermaid
graph TD
    A[Document Upload] --> B[Select PDF File]
    B --> C[Validate PDF]
    C --> D{Valid PDF?}
    D -->|No| E[Invalid File Error]
    D -->|Yes| F[Check Size Limit]
    
    F --> G{Size Under 5MB?}
    G -->|No| H[File Too Large]
    G -->|Yes| I[Upload to Server]
    
    I --> J[Generate Metadata]
    J --> K[Save File Info]
    K --> L[Update File List]
    L --> M[Success Confirmation]
```

## 🔍 Data Flow Architecture

### Data Storage Flow
```mermaid
graph TD
    A[User Input] --> B[Form Processing]
    B --> C[Data Validation]
    C --> D{Valid Data?}
    D -->|No| E[Return Errors]
    D -->|Yes| F[Sanitize Data]
    
    F --> G[Load JSON File]
    G --> H[Update Data Structure]
    H --> I[Save JSON File]
    I --> J{Save Success?}
    J -->|No| K[Save Error]
    J -->|Yes| L[Success Response]
```

### Settings Management Flow
```mermaid
graph TD
    A[Settings Page] --> B[Load Current Settings]
    B --> C[Display Form]
    C --> D[User Modifications]
    D --> E[Form Submission]
    
    E --> F[Validate Input]
    F --> G{Valid?}
    G -->|No| H[Show Validation Errors]
    G -->|Yes| I[Update settings.json]
    
    I --> J{Update Success?}
    J -->|No| K[Show Error Message]
    J -->|Yes| L[Show Success Message]
    L --> M[Reload Settings]
```

## 🔒 Security Flow

### Session Management Flow
```mermaid
graph TD
    A[User Login] --> B[Validate Credentials]
    B --> C{Valid?}
    C -->|No| D[Login Failed]
    C -->|Yes| E[Create Session]
    
    E --> F[Set Session Variables]
    F --> G[Set Session Timeout]
    G --> H[User Authenticated]
    
    H --> I[Each Page Request]
    I --> J[Check Session]
    J --> K{Session Valid?}
    K -->|No| L[Redirect to Login]
    K -->|Yes| M[Allow Access]
    
    M --> N[Update Last Activity]
    N --> O[Continue Session]
```

### File Security Flow
```mermaid
graph TD
    A[File Access Request] --> B[Check File Location]
    B --> C{In Upload Directory?}
    C -->|No| D[Direct Access Allowed]
    C -->|Yes| E[Check File Type]
    
    E --> F{Allowed Type?}
    F -->|No| G[Access Denied]
    F -->|Yes| H[Check User Permission]
    
    H --> I{Admin User?}
    I -->|No| J[Public File Check]
    I -->|Yes| K[Allow Access]
    
    J --> L{Public File?}
    L -->|No| M[Access Denied]
    L -->|Yes| N[Allow Access]
```

## 📱 Responsive Design Flow

### Device Detection Flow
```mermaid
graph TD
    A[Page Load] --> B[Detect Screen Size]
    B --> C{Screen Width}
    C -->|< 768px| D[Mobile Layout]
    C -->|768px - 1024px| E[Tablet Layout]
    C -->|> 1024px| F[Desktop Layout]
    
    D --> G[Mobile Navigation]
    D --> H[Single Column Layout]
    D --> I[Touch-Friendly Elements]
    
    E --> J[Tablet Navigation]
    E --> K[Two Column Layout]
    
    F --> L[Full Navigation]
    F --> M[Multi Column Layout]
    F --> N[Hover Effects]
```

## 🚀 Performance Optimization Flow

### Page Load Optimization
```mermaid
graph TD
    A[Page Request] --> B[Check Cache]
    B --> C{Cached?}
    C -->|Yes| D[Serve Cached Version]
    C -->|No| E[Generate Page]
    
    E --> F[Load Required Data]
    F --> G[Process PHP]
    G --> H[Render HTML]
    H --> I[Optimize Images]
    I --> J[Minify CSS/JS]
    J --> K[Set Cache Headers]
    K --> L[Send Response]
    
    D --> M[Check Cache Validity]
    M --> N{Still Valid?}
    N -->|Yes| O[Serve Cache]
    N -->|No| E
```

## 📊 Error Handling Flow

### Error Management Flow
```mermaid
graph TD
    A[Application Error] --> B[Error Type Detection]
    B --> C{Error Type}
    C -->|PHP Error| D[Log PHP Error]
    C -->|User Error| E[Show User Message]
    C -->|System Error| F[Log System Error]
    
    D --> G[Error Log File]
    E --> H[User-Friendly Message]
    F --> I[System Log]
    
    G --> J[Admin Notification]
    H --> K[Redirect/Retry Option]
    I --> L[System Monitoring]
```

## 🔄 Backup and Recovery Flow

### Backup Process Flow
```mermaid
graph TD
    A[Backup Trigger] --> B[Create Backup Directory]
    B --> C[Copy Application Files]
    C --> D[Backup Data Files]
    D --> E[Backup Upload Files]
    E --> F[Create Archive]
    F --> G[Verify Backup]
    G --> H{Backup Valid?}
    H -->|No| I[Backup Failed]
    H -->|Yes| J[Store Backup]
    J --> K[Clean Old Backups]
    K --> L[Backup Complete]
```

---

This comprehensive flowchart documentation provides visual representation of all major processes and user flows in the NAF Public School website application.
