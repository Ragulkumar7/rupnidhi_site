<?php
session_start();

// SECURITY: Generate a CSRF token to prevent cross-site request forgery
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// REDIRECT: If user is already logged in, send them to their folder automatically
if (isset($_SESSION['target_folder'])) {
    header("Location: ./" . htmlspecialchars($_SESSION['target_folder']) . "/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Rupnidhi Enterprise AI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                DEFAULT: '#2b1867', // Deep Indigo Brand Color
                hover: '#3c248f',
                light: '#f4f1fb'
              }
            },
            fontFamily: {
              sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            }
          }
        }
      }
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V8R88VX8TT"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-V8R88VX8TT');
    </script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans text-gray-800 antialiased">

    <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 rounded-[2rem] overflow-hidden shadow-[0_20px_60px_rgba(43,24,103,0.08)] border border-gray-100 bg-white">
        
        <div class="hidden md:flex flex-col justify-between p-14 bg-brand text-white relative overflow-hidden">
            <div class="z-10">
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-extrabold tracking-tight">Rupnidhi</h1>
                </div>
                <p class="text-brand-light/80 font-medium tracking-wide uppercase text-xs">Enterprise AI Operations Portal</p>
            </div>
            
            <div class="z-10 mb-8">
                <h2 class="text-4xl font-extrabold leading-tight mb-4">Manage your <br><span class="text-brand-light opacity-90">global billing</span><br>with AI precision.</h2>
                <p class="text-white/70 text-base leading-relaxed max-w-sm">Compliant with ZATCA, VAT, and multi-currency standards. Powered by Neoera Infotech.</p>
            </div>

            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-brand-hover rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
            <div class="absolute top-10 right-10 w-48 h-48 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute top-1/2 right-0 transform translate-x-1/3 -translate-y-1/2 w-64 h-80 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-sm rotate-12"></div>
        </div>

        <div class="p-8 md:p-14 lg:p-16 flex flex-col justify-center bg-white relative">
            <div class="mb-10 text-center md:text-left">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back</h3>
                <p class="text-gray-500 text-sm font-medium">Please enter your credentials to access your account.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-medium flex items-center shadow-sm">
                    <i class="fa-solid fa-circle-exclamation mr-3 text-red-500 text-lg"></i>
                    <span>
                    <?php 
                        $err = htmlspecialchars($_GET['error']);
                        if($err == 'invalid') echo "Invalid password. Please try again.";
                        if($err == 'notfound') echo "Email address not recognized.";
                        if($err == 'csrf') echo "Security token mismatch. Please refresh.";
                    ?>
                    </span>
                </div>
            <?php endif; ?>

            <form action="process_login.php" method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Business Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 font-medium placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand/10 focus:border-brand transition-all"
                            placeholder="name@company.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 font-medium placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-brand/10 focus:border-brand transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center text-sm font-medium text-gray-600 cursor-pointer hover:text-gray-900 transition-colors">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-brand focus:ring-brand mr-2 cursor-pointer transition-colors">
                        Remember me
                    </label>
                    <a href="#" class="text-sm font-bold text-brand hover:text-brand-hover transition-colors">Forgot password?</a>
                </div>

                <button type="submit" 
                    class="w-full py-4 px-4 mt-4 bg-brand hover:bg-brand-hover text-white font-bold rounded-xl shadow-[0_8px_20px_rgba(43,24,103,0.2)] transform transition-all hover:-translate-y-[1px] active:translate-y-[1px]">
                    Sign In to Portal <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                </button>

                <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                    <p class="text-[11px] text-gray-400 uppercase tracking-widest font-bold flex items-center justify-center gap-2">
                        <i class="fa-solid fa-shield-halved text-gray-300"></i> Secured by Neoera Centralized Login
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>