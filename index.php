                   <?php
                   if ($_SERVER["REQUEST_METHOD"] == "POST") {
                       // 出力バッファリングを開始
                       ob_start();
                   
                       // 入力データを取得
                       $username_input = htmlspecialchars($_POST['username']);
                       $email = htmlspecialchars($_POST['email']);
                       $message = htmlspecialchars($_POST['message']);
                       
                       // タイムスタンプを取得
                       $timestamp = date('Y-m-d H:i');
                       

                       // データベースに接続
                       $servername = ".db.sakura.ne.jp";
                       $username_db = "gs1";  // データベースユーザー名
                       $password_db = "--";  // データベースパスワード
                       $dbname = "gs1_pj1";
                       
                       $conn = new mysqli($servername, $username_db, $password_db, $dbname);
                       
                       if ($conn->connect_error) {
                           die("Connection failed: " . $conn->connect_error);
                       }
                   
                       // ユーザー情報をデータベースに保存
                       $stmt = $conn->prepare("INSERT INTO users (username, email, message, timestamp) VALUES (?, ?, ?, ?)");
                       if ($stmt === false) {
                           die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                       }
                       if ($stmt->bind_param("ssss", $username_input, $email, $message, $timestamp) === false) {
                           die("Bind param failed: (" . $stmt->errno . ") " . $stmt->error);
                       }
                       if ($stmt->execute() === false) {
                           die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
                       } else {
                           // 新しいユーザーIDを取得
                           $user_id = $stmt->insert_id;
                           // ハッシュIDを生成
                           $hashed_id = hash('sha256', $user_id);
                   
                           // ハッシュIDをデータベースに保存
                           $stmt_update = $conn->prepare("UPDATE users SET hashed_id = ? WHERE id = ?");
                           if ($stmt_update === false) {
                               die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                           }
                           if ($stmt_update->bind_param("si", $hashed_id, $user_id) === false) {
                               die("Bind param failed: (" . $stmt_update->errno . ") " . $stmt_update->error);
                           }
                           if ($stmt_update->execute() === false) {
                               die("Execute failed: (" . $stmt_update->errno . ") " . $stmt_update->error);
                           }
                   
                           // ユーザー登録が成功した場合、リダイレクト
                           header('Location: success.php');
                           // 出力バッファリングを終了し、バッファを出力
                           ob_end_flush();
                           exit();
                       }
                   
                       $stmt->close();
                       $conn->close();
                   }
                   ?>
                   
               
    
    <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Management & Consulting Labo</title>
    <link rel="stylesheet" href="css/styles.css">
        <!-- Google Fontsのインポート -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap">
</head>
<body>
    <header>
        <div class="overlay"></div>
        <div class="container">
            <h1>Health Management & Consulting Labo</h1>
            <p>医療・健康・公衆衛生・労働安全領域で豊富なプロジェクト経験を持つ専門家チームが、最新の医療・社会疫学・行動科学等の研究に基づく安全で持続可能な組織体制づくり、プロジェクトマネジメント、人事制度設計等をお手伝いします。</p>
            <p>誰しも平等に心身の変化は訪れ、健康リスクは予防できることとできないことがあります。少子高齢化が進む現代社会において、あらゆる組織が持続していくためには、そのような人間の心身への冷静で客観的かつ十分な知識と様々な現場における人間組織ならではのジレンマの実態への知識の両方を用いて丁寧に経営層や従業員をサポート、伴走していく人材が不可欠であると私たちは考えます。</p>
            <p>私たちは、特に「企業健康管理」「健康経営」「科学的エビデンスに基づいた調査・研究」の経験や知見を最大の強みとしておりますが、その他の領域においても在籍・協業を多数経験しております。未来を見据えた地域・社会・経済活動の中における「垣根のない持続的な体制づくりおよびコンサルティング」を目指しておりますので、あらゆる組織からのご相談をお受けします。お気軽にご相談下さい。</p>
            <div class="buttons">
                <a href="#contact" class="btn btn-primary">ご相談</a>
                <a href="#about" class="btn btn-secondary">会社概要を見る</a>
            </div>
        </div>
    </header>
    <section id="about">
        <div class="container">
            <h2>私たちのサービス</h2>
            <p class="subtitle">～いつの間にか健康になる社会の構築～</p>
            <div class="service-content">
                <img src="img/about.png" alt="サービスイメージ">
                <div class="service-details">
                    <div class="service-item">
                        <div class="service-text">
                            <h3>経営層・従業員のための真の健康管理体制づくり</h3>
                            <p>少子高齢化が進む中、限りある人的資本を活かして企業が存続し続けるには、誰にでも平等に訪れる心身の変化やかつての社会や社風により育まれた価値観の世代間ギャップ等の事実に客観的に向き合い、寄り添い、企業としての幸せと人間としての幸せの両立を模索しながら経営層と従業員が一緒に、生産性の向上を目指していく必要があります。</p>
                            <p>私たちは、企業を「1人1人の人間の集合体」と捉え、これからの未来に持続可能な真の「健康経営」「健康管理体制づくり」に一緒に向き合ってきます。</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <div class="service-text">
                            <h3>社会の中における企業価値向上</h3>
                            <p>私たちは、企業・自治体・国が連携した日本の医療・健康体制づくりに貢献します。企業個別の取り組みが一過性ではなく未来の社会づくりにつながることを見据えた中長期的かつ幅広い視点での支援を提供することで、ESG経営の観点からの企業価値向上にも貢献します。</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <div class="service-text">
                            <h3>健康経営優良法人・健康経営銘柄取得支援</h3>
                            <p>大規模法人での健康経営銘柄およびホワイト500、中小規模法人でのブライト500取得体制づくりをゼロベースから支援した経験（約40企業）から、まずは健康経営優良法人取得を！という企業様へは、ヒアリングの上、最短の道をご提案可能です。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="ceo">
        <div class="container">
            <h2>代表取締役の経歴</h2>
            <div class="ceo-content">
                <div class="ceo-photo">
                    <img src="img/ceo.png" alt="代表取締役">
                </div>
                <div class="ceo-details">
                    <div class="ceo-text">
                        <h3>学歴</h3>
                        <p>山形大学医学部看護学科卒業<br>
                        慶應義塾大学大学院健康マネジメント研究科公衆衛生学修士課程卒業<br>
                        慶応義塾大学大学院健康マネジメント研究科医療経済評価人材育成プログラムサーティフィケート取得<br>
                        慶応義塾大学経営管理研究科科目履修（起業体験・病院経営・データ分析関連・コーチング等）</p>
                    </div>
                    <div class="ceo-text">
                        <h3>資格</h3>
                        <p>看護師<br>保健師<br>公衆衛生学修士<br>第一種衛生管理者<br>健康経営アドバイザー<br>心理相談員等</p>
                    </div>
                    <div class="ceo-text">
                        <h3>実務経験</h3>
                        <p>小児科～成人終末期の病棟・外来看護<br>
                        製薬・ヘルスケアデバイス臨床試験<br>
                        健康経営コンサルティング<br>
                        労働安全衛生業務全般<br>
                        多数新規ヘルスケア関連事業創出<br>
                        多数ヘルスケア関連プロジェクトマネジメント<br>
                        多数新規システム導入プロジェクトマネジメント<br>
                        ヘルスケアスタートアップseed期支援<br>
                        国際保健NPO<br>
                        各種データ分析<br>
                        医学系学会発表・論文執筆等</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="team">
        <div class="container">
            <h2>多彩なスタッフ</h2>
            <div class="staff-grid">
                <div class="staff-member">
                    <img src="img/ns.png" alt="病院看護師アイコン">
                    <h3>病院看護師</h3>
                    <p>豊富な病棟・外来経験</p>
                </div>
                <div class="staff-member">
                    <img src="img/phn.png" alt="行政保健師アイコン">
                    <h3>行政保健師</h3>
                    <p>地域の健康・安全</p>
                </div>
                <div class="staff-member">
                    <img src="img/nt.png" alt="管理栄養士アイコン">
                    <h3>管理栄養士</h3>
                    <p>食生活改善</p>
                </div>
                <div class="staff-member">
                    <img src="img/mt.png" alt="心理専門職アイコン">
                    <h3>心理専門職</h3>
                    <p>メンタルヘルス</p>
                </div>
                <div class="staff-member">
                    <img src="img/others.png" alt="衛生管理者アイコン">
                    <h3>衛生管理者</h3>
                    <p>豊富な安全衛生実務</p>
                </div>
                <div class="staff-member">
                    <img src="img/others.png" alt="産業医・保健師アイコン">
                    <h3>産業医・保健師</h3>
                    <p>企業の健康・安全</p>
                </div>
                <div class="staff-member">
                    <img src="img/others.png" alt="健保組合保健師アイコン">
                    <h3>健保組合保健師</h3>
                    <p>保険者の健康課題</p>
                </div>
                <div class="staff-member">
                    <img src="img/others.png" alt="保育園保健師アイコン">
                    <h3>保育園保健師</h3>
                    <p>小児の健康・安全</p>
                </div>
            </div>
        </div>
    </section>
    <section id="research">
    <div class="container">
        <h2>研究・実践の融合</h2>
        <div class="research-content">
            <div class="research-details">
                <div class="research-item">
                    <div class="research-arrow">1</div>
                    <div class="research-text">
                        <h3>研究経験</h3>
                        <p>企業、研究機関での研究結果を学会発表、論文執筆経験。研究を通じて国の施策や通知等の目的や意図、検討すべき課題を正しく理解した上での、必要に応じた提言経験。</p>
                    </div>
                </div>
                <div class="research-item">
                    <div class="research-arrow">2</div>
                    <div class="research-text">
                        <h3>実践経験</h3>
                        <p>病院や企業での多くの命の現場への直面・対応経験、企業等での社員の一員としての医療の枠にとらわれないあらゆる業務への従事経験。</p>
                    </div>
                </div>
                <div class="research-item">
                    <div class="research-arrow">3</div>
                    <div class="research-text">
                        <h3>双方向のフィードバック</h3>
                        <p>研究と実践での経験・知識・人脈を相互に適切に活かし合いながら、科学的エビデンスに基づいた個人・組織・社会の健康課題を抽出。研究と実践の間の橋渡し。</p>
                    </div>
                </div>
            </div>
            <div class="research-photo">
                <img src="img/re.png" alt="研究・実践の融合">
            </div>
        </div>
    </div>
</section>

    <section id="contact">
        <div class="container">
            <h2>ご相談・お問い合わせ</h2>
            <form action="index.php" method="post">
                <label for="name">お名前:</label>
                <input type="text" id="name" name="username" required>
                
                <label for="email">メールアドレス:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">メッセージ:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit">送信</button>
            </form>
        </div>
    </section>
</body>
</html>