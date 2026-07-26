import os
import sys
from reportlab.lib.pagesizes import letter
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, PageBreak, KeepTogether, HRFlowable
)

def build_pdf(filename):
    doc = SimpleDocTemplate(
        filename,
        pagesize=letter,
        rightMargin=40,
        leftMargin=40,
        topMargin=40,
        bottomMargin=40
    )

    styles = getSampleStyleSheet()

    # Custom styles
    primary_color = colors.HexColor('#1E293B')   # Dark Slate
    secondary_color = colors.HexColor('#0284C7') # Sky Blue
    accent_color = colors.HexColor('#0F172A')    # Deep Charcoal
    bg_code = colors.HexColor('#F8FAFC')         # Light Grey Code BG
    border_code = colors.HexColor('#CBD5E1')

    title_style = ParagraphStyle(
        'DocTitle',
        parent=styles['Heading1'],
        fontName='Helvetica-Bold',
        fontSize=24,
        leading=28,
        textColor=primary_color,
        spaceAfter=10
    )

    subtitle_style = ParagraphStyle(
        'DocSubTitle',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=12,
        leading=16,
        textColor=colors.HexColor('#475569'),
        spaceAfter=20
    )

    h1_style = ParagraphStyle(
        'H1',
        parent=styles['Heading1'],
        fontName='Helvetica-Bold',
        fontSize=16,
        leading=20,
        textColor=secondary_color,
        spaceBefore=15,
        spaceAfter=8,
        keepWithNext=True
    )

    h2_style = ParagraphStyle(
        'H2',
        parent=styles['Heading2'],
        fontName='Helvetica-Bold',
        fontSize=12,
        leading=16,
        textColor=primary_color,
        spaceBefore=10,
        spaceAfter=6,
        keepWithNext=True
    )

    body_style = ParagraphStyle(
        'Body',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=10,
        leading=14,
        textColor=accent_color,
        spaceAfter=6
    )

    bullet_style = ParagraphStyle(
        'Bullet',
        parent=body_style,
        leftIndent=15,
        spaceAfter=4
    )

    code_style = ParagraphStyle(
        'Code',
        fontName='Courier',
        fontSize=8,
        leading=11,
        textColor=colors.HexColor('#0F172A'),
        backColor=bg_code,
        borderColor=border_code,
        borderWidth=0.5,
        borderPadding=6,
        spaceAfter=8
    )

    story = []

    # Document Header
    story.append(Paragraph("PHP Application Architecture & Refactoring Report", title_style))
    story.append(Paragraph("Comprehensive Technical Documentation of Architecture, Security, Validation, and JWT Single Device Session", subtitle_style))
    story.append(HRFlowable(width="100%", thickness=1.5, color=secondary_color, spaceAfter=15))

    # Executive Summary
    story.append(Paragraph("1. Executive Summary", h1_style))
    exec_summary = (
        "This technical report documents the end-to-end refactoring and architectural enhancements implemented "
        "for the Native PHP Student & Course Management Application. The updates elevate the codebase to modern "
        "framework standards (inspired by Laravel and Symfony), adhering to <b>SOLID Principles</b>, <b>DRY (Don't Repeat Yourself)</b>, "
        "and <b>Security Best Practices</b>.<br/><br/>"
        "Key milestones include: Application Bootstrapping (.env, ConfigManager, Container), Enterprise Security "
        "(CORS, Security Headers, IP Rate Limiter, SQL Injection Identifier Sanitization), Validation Engine "
        "(Real Email DNS MX lookup & Egyptian Mobile Phone format), Laravel-style FormRequest architecture, and "
        "JWT Authentication featuring a strict <b>Single Device Active Session Constraint</b>."
    )
    story.append(Paragraph(exec_summary, body_style))
    story.append(Spacer(1, 10))

    # Architecture & Bootstrapping
    story.append(Paragraph("2. Bootstrapping & Core Architecture", h1_style))

    story.append(Paragraph("2.1 Environment Loader (Core\\Environment\\EnvLoader)", h2_style))
    story.append(Paragraph(
        "Parses the <code>.env</code> file into <code>$_ENV</code>, <code>$_SERVER</code>, and <code>putenv()</code>. "
        "Converts boolean strings ('true'/'false') and null values into native PHP types.", body_style
    ))
    env_code = (
        "&lt;?php<br/>"
        "namespace Core\\Environment;<br/><br/>"
        "class EnvLoader {<br/>"
        "&nbsp;&nbsp;public function load(string $filePath): void {<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;if (!file_exists($filePath)) throw new \\RuntimeException(\"Not found\");<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;$lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;foreach ($lines as $line) {<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if (str_starts_with(trim($line), '#')) continue;<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[$key, $value] = explode('=', trim($line), 2);<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$_ENV[trim($key)] = trim($value, \"'\\\"\");<br/>"
        "&nbsp;&nbsp;&nbsp;&nbsp;}<br/>"
        "&nbsp;&nbsp;}<br/>"
        "}"
    )
    story.append(Paragraph(env_code, code_style))

    story.append(Paragraph("2.2 Configuration Management (Core\\Config\\ConfigManager & ConfigLoader)", h2_style))
    story.append(Paragraph(
        "Scans all PHP array files in <code>config/</code> and provides dot-notation access (e.g. <code>config('database.dbname')</code>).", body_style
    ))

    story.append(Paragraph("2.3 Dependency Injection Container (Core\\Container)", h2_style))
    story.append(Paragraph(
        "Upgraded Container supporting <code>bind()</code>, <code>instance()</code>, and <code>make()</code> with recursive Reflection "
        "parameter resolution.", body_style
    ))

    story.append(Paragraph("2.4 Application Core (Core\\Application)", h2_style))
    story.append(Paragraph(
        "Central orchestrator class initializing Environment loading, Config loading, Container setup, Database connection, Session, "
        "and Router dispatching.", body_style
    ))
    story.append(Spacer(1, 10))

    # Security Enhancements
    story.append(Paragraph("3. Security Features", h1_style))

    story.append(Paragraph("3.1 CORS Middleware (App\\Http\\Middleware\\CorsMiddleware)", h2_style))
    story.append(Paragraph(
        "Manages Cross-Origin Resource Sharing headers (<code>Access-Control-Allow-Origin</code>, <code>Methods</code>, <code>Headers</code>) "
        "and intercepts HTTP <code>OPTIONS</code> preflight requests.", body_style
    ))

    story.append(Paragraph("3.2 Security Headers Middleware (App\\Http\\Middleware\\SecurityHeadersMiddleware)", h2_style))
    story.append(Paragraph(
        "Injects <code>X-Frame-Options: SAMEORIGIN</code>, <code>X-Content-Type-Options: nosniff</code>, "
        "<code>X-XSS-Protection: 1; mode=block</code>, and <code>Referrer-Policy</code>.", body_style
    ))

    story.append(Paragraph("3.3 Rate Limiter Middleware (App\\Http\\Middleware\\RateLimiterMiddleware)", h2_style))
    story.append(Paragraph(
        "Throttles incoming requests by client IP address (max 60 requests/min). Returns HTTP 429 Too Many Requests with "
        "<code>Retry-After</code> headers when limit is exceeded.", body_style
    ))

    story.append(Paragraph("3.4 XSS Output Protection", h2_style))
    story.append(Paragraph(
        "Introduced global <code>e(?string $value)</code> helper in <code>app/Helpers/view.php</code> utilizing "
        "<code>htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')</code>.", body_style
    ))

    story.append(Paragraph("3.5 SQL Injection Prevention in Model.php", h2_style))
    story.append(Paragraph(
        "Sanitizes raw table names and dynamic column arrays using regex identifier cleaning "
        "(<code>preg_replace('/[^a-zA-Z0-9_]/', '', $identifier)</code>) and backtick wrapping with PDO binding.", body_style
    ))
    model_code = (
        "protected static function sanitizeIdentifier(string $identifier): string {<br/>"
        "&nbsp;&nbsp;$clean = preg_replace('/[^a-zA-Z0-9_]/', '', $identifier);<br/>"
        "&nbsp;&nbsp;if (empty($clean)) throw new \\InvalidArgumentException(\"Invalid identifier\");<br/>"
        "&nbsp;&nbsp;return \"`{$clean}`\";<br/>"
        "}"
    )
    story.append(Paragraph(model_code, code_style))
    story.append(Spacer(1, 10))

    # Page Break for Validation & FormRequests
    story.append(PageBreak())

    # Validation Engine & Form Requests
    story.append(Paragraph("4. Request Validation & FormRequest Architecture", h1_style))

    story.append(Paragraph("4.1 Upgraded Core\\Validator", h2_style))
    story.append(Paragraph("Supports rule execution, custom messages, and specialized rules:", body_style))
    story.append(Paragraph("• <b>email</b>: Validates format + checks domain MX/A DNS records via <code>checkdnsrr()</code> to verify real emails.", bullet_style))
    story.append(Paragraph("• <b>egyptian_phone</b>: Validates Egyptian mobile phone numbers (Vodafone <code>010</code>, Etisalat <code>011</code>, Orange <code>012</code>, WE <code>015</code>) and international format <code>+20...</code> using <code>/^(?:\\+20|0020|0)?1[0125]\\d{8}$/</code>.", bullet_style))
    story.append(Paragraph("• <b>required, min, max, numeric, string, in</b>: Standard rule validations.", bullet_style))

    story.append(Paragraph("4.2 Laravel-Style FormRequest (Core\\Http\\FormRequest)", h2_style))
    story.append(Paragraph(
        "Abstract class decoupling request validation, rules, custom Arabic error messages, and authorization from controllers.", body_style
    ))
    form_req_code = (
        "&lt;?php<br/>"
        "namespace Core\\Http;<br/><br/>"
        "abstract class FormRequest extends Request {<br/>"
        "&nbsp;&nbsp;abstract public function rules(): array;<br/>"
        "&nbsp;&nbsp;public function messages(): array { return []; }<br/>"
        "&nbsp;&nbsp;public function authorize(): bool { return true; }<br/>"
        "&nbsp;&nbsp;public function validate(array $rules = [], array $messages = []): Validator { ... }<br/>"
        "&nbsp;&nbsp;public function passes(): bool { return $this-&gt;validator-&gt;passes(); }<br/>"
        "&nbsp;&nbsp;public function fails(): bool { return $this-&gt;validator-&gt;fails(); }<br/>"
        "&nbsp;&nbsp;public function errors(): array { return $this-&gt;validator-&gt;errors(); }<br/>"
        "}"
    )
    story.append(Paragraph(form_req_code, code_style))

    story.append(Paragraph("4.3 Dedicated Application Requests (app/Http/Requests/*)", h2_style))
    story.append(Paragraph("• <b>StudentStoreRequest</b> & <b>StudentUpdateRequest</b>: Validates full_name, real email, Egyptian phone numbers, age, gender, address, dep_id.", bullet_style))
    story.append(Paragraph("• <b>LoginRequest</b>: Validates real email format and password.", bullet_style))
    story.append(Paragraph("• <b>DepartmentRequest</b>: Validates department name.", bullet_style))
    story.append(Spacer(1, 10))

    # JWT & Single Device Session
    story.append(Paragraph("5. JWT Authentication & Single Device Active Session", h1_style))

    story.append(Paragraph("5.1 Database Table Schema (user_tokens)", h2_style))
    story.append(Paragraph("Database table for managing active sessions and single-device constraints:", body_style))
    sql_code = (
        "CREATE TABLE IF NOT EXISTS user_tokens (<br/>"
        "&nbsp;&nbsp;id INT AUTO_INCREMENT PRIMARY KEY,<br/>"
        "&nbsp;&nbsp;user_id INT NOT NULL,<br/>"
        "&nbsp;&nbsp;user_type VARCHAR(20) NOT NULL DEFAULT 'student',<br/>"
        "&nbsp;&nbsp;jwt_token TEXT NOT NULL,<br/>"
        "&nbsp;&nbsp;remember_token VARCHAR(255) NULL,<br/>"
        "&nbsp;&nbsp;device_identifier VARCHAR(255) NOT NULL,<br/>"
        "&nbsp;&nbsp;ip_address VARCHAR(45) NULL,<br/>"
        "&nbsp;&nbsp;user_agent TEXT NULL,<br/>"
        "&nbsp;&nbsp;expires_at DATETIME NOT NULL,<br/>"
        "&nbsp;&nbsp;created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,<br/>"
        "&nbsp;&nbsp;updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,<br/>"
        "&nbsp;&nbsp;UNIQUE KEY unique_user_device (user_id, user_type)<br/>"
        ");"
    )
    story.append(Paragraph(sql_code, code_style))

    story.append(Paragraph("5.2 Strict Single Device Active Session Policy", h2_style))
    story.append(Paragraph(
        "When a student or admin logs in, a unique device fingerprint hash (IP + User Agent) is saved in <code>user_tokens</code>. "
        "If a second device attempts to log in while an active session exists on another device, the login is <b>STRICTLY BLOCKED</b> "
        "with HTTP 403 Forbidden and the error message:", body_style
    ))
    story.append(Paragraph(
        "<i>'عذراً، هذا الحساب مفتوح حالياً على جهاز آخر. يجب تسجيل الخروج من الجهاز الأول أولاً لتتمكن من الدخول من هذا الجهاز.'</i>",
        ParagraphStyle('ArMsg', parent=body_style, textColor=colors.HexColor('#DC2626'), fontName='Helvetica-Oblique', leftIndent=15)
    ))
    story.append(Paragraph(
        "A secondary device can ONLY gain access if the first device explicitly performs a <code>/logout</code> (which revokes the token record) "
        "or after the session reaches expiration (<code>expires_at &lt;= NOW</code>).", body_style
    ))

    story.append(Paragraph("5.3 JwtAuthMiddleware (App\\Http\\Middleware\\JwtAuthMiddleware)", h2_style))
    story.append(Paragraph(
        "Extracts JWT from <code>Authorization: Bearer</code> or cookie, decodes token with HMAC SHA-256, verifies token against "
        "database record in <code>user_tokens</code>, and confirms device signature matches current request.", body_style
    ))
    story.append(Spacer(1, 10))

    # Architecture Verification Table
    story.append(Paragraph("6. Project Component Summary Table", h1_style))

    table_data = [
        ["Component / Module", "Class Name", "Primary Rationale & Design Pattern"],
        ["Environment", "Core\\Environment\\EnvLoader", "Parses .env into $_ENV & type-casts values"],
        ["Config Engine", "Core\\Config\\ConfigManager", "Dot-notation access for configuration options"],
        ["DI Container", "Core\\Container", "Reflection auto-resolution, bindings, singletons"],
        ["Application Core", "Core\\Application", "Central bootstrap orchestrator for app lifecycle"],
        ["CORS Security", "App\\Http\\Middleware\\CorsMiddleware", "Sets CORS headers & handles OPTIONS preflight"],
        ["Headers Security", "App\\Http\\Middleware\\SecurityHeadersMiddleware", "Sets X-Frame-Options, XSS, & nosniff headers"],
        ["Rate Limiter", "App\\Http\\Middleware\\RateLimiterMiddleware", "Throttles client requests by IP (HTTP 429)"],
        ["SQL Sanitization", "Core\\Model", "Regex identifier cleaning & PDO parameter binding"],
        ["Validation Engine", "Core\\Validator", "Rule engine with real DNS email & Egyptian phone"],
        ["Form Requests", "Core\\Http\\FormRequest", "Laravel-style validation & custom message decoupling"],
        ["JWT Manager", "Core\\Auth\\JwtManager", "HMAC SHA-256 token encoding & decoding"],
        ["Active Token Model", "App\\Model\\UserToken", "Upsert database tracking for single active device"],
        ["JWT Middleware", "App\\Http\\Middleware\\JwtAuthMiddleware", "Enforces valid token & single active device rule"],
        ["JWT Controller", "App\\Http\\Controllers\\JwtAuthController", "Handles login, logout, remember token, & conflict response"]
    ]

    t = Table(table_data, colWidths=[110, 160, 260])
    t.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), primary_color),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 9),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 6),
        ('TOPPADDING', (0, 0), (-1, 0), 6),
        ('GRID', (0, 0), (-1, -1), 0.5, border_code),
        ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
        ('FONTNAME', (0, 1), (-1, -1), 'Helvetica'),
        ('FONTSIZE', (0, 1), (-1, -1), 8),
        ('ROWBACKGROUNDS', (0, 1), (-1, -1), [colors.white, colors.HexColor('#F1F5F9')]),
    ]))

    story.append(t)
    story.append(Spacer(1, 15))

    # Conclusion
    story.append(Paragraph("7. Conclusion", h1_style))
    story.append(Paragraph(
        "The project has been transformed from a basic script into an enterprise-grade Native PHP Web Application. "
        "All SOLID design violations, security vulnerabilities, and architectural missing components identified in the original audit "
        "have been resolved with full test validation.", body_style
    ))

    doc.build(story)
    print(f"PDF generated successfully: {filename}")

if __name__ == '__main__':
    pdf_path = os.path.abspath("PHP_Project_Refactoring_Documentation.pdf")
    build_pdf(pdf_path)
