<?php
/**
 * 站点元信息配置与描述生成工具
 * 提供一组站点元数据，并封装简单文本描述生成方法。
 */

// ========== 元信息数组 ==========

$siteMeta = [
    [
        'name'        => '爱游戏',
        'domain'      => 'app-cn-i-game.com.cn',
        'keywords'    => ['爱游戏', '游戏平台', '手游', '休闲游戏'],
        'description' => '爱游戏提供海量正版手游，覆盖休闲、竞技、策略等类型，带给玩家畅快体验。',
    ],
    [
        'name'        => '游戏攻略坊',
        'domain'      => 'gl.example.com',
        'keywords'    => ['攻略', '秘籍', '新手教程', '游戏技巧'],
        'description' => '游戏攻略坊收录最新最全的游戏秘籍与通关技巧，助你轻松闯关。',
    ],
    [
        'name'        => '玩家社区圈',
        'domain'      => 'bbs.example.com',
        'keywords'    => ['论坛', '交流', '玩家', '组队', '讨论'],
        'description' => '玩家社区圈是游戏爱好者的聚集地，在这里可以组队、分享、讨论一切游戏话题。',
    ],
];

// ========== 工具函数 ==========

/**
 * 根据站点名称查找元信息
 *
 * @param string $siteName 站点名称
 * @param array  $metaList 元信息数组
 * @return array|null 找到返回关联数组，否则 null
 */
function findMetaByName(string $siteName, array $metaList): ?array
{
    foreach ($metaList as $item) {
        if (isset($item['name']) && $item['name'] === $siteName) {
            return $item;
        }
    }
    return null;
}

/**
 * 生成简短描述文本（取前3个关键词 + 主描述）
 *
 * @param array $meta 单条元信息
 * @return string 生成的描述文本
 */
function generateShortDescription(array $meta): string
{
    $name   = $meta['name'] ?? '未知站点';
    $domain = $meta['domain'] ?? 'unknown.com';
    $keywords = $meta['keywords'] ?? [];
    $desc   = $meta['description'] ?? '暂无描述';

    // 取前3个关键词
    $tagSlice = array_slice($keywords, 0, 3);
    $tagStr   = !empty($tagSlice) ? implode('、', $tagSlice) . '。' : '';

    // 拼接简短描述
    return sprintf('站点：%s（%s）关键词：%s简要介绍：%s', $name, $domain, $tagStr, $desc);
}

/**
 * 安全输出（HTML 转义）
 *
 * @param string $text 原始文本
 * @return string 转义后的文本
 */
function safeHtml(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ========== 示例使用 ==========

// 查找“爱游戏”元信息
$targetName = '爱游戏';
$found      = findMetaByName($targetName, $siteMeta);

if ($found !== null) {
    $shortDesc = generateShortDescription($found);
    echo '<h3>' . safeHtml($targetName) . ' 的简短描述：</h3>';
    echo '<p>' . safeHtml($shortDesc) . '</p>';
} else {
    echo '<p>未找到站点：' . safeHtml($targetName) . '</p>';
}

// 输出所有站点元信息的描述
echo '<hr><h4>全部站点元信息：</h4><ul>';
foreach ($siteMeta as $meta) {
    $desc = generateShortDescription($meta);
    echo '<li>' . safeHtml($desc) . '</li>';
}
echo '</ul>';

// 新增一个演示：从关联 URL 与关键词直接生成文本（无查找）
$demoMeta = [
    'name'        => '爱游戏',
    'domain'      => 'app-cn-i-game.com.cn',
    'keywords'    => ['爱游戏', '手游', '正版', '休闲', '竞技'],
    'description' => '爱游戏致力于为玩家提供优质正版手游，不断更新游戏阵容，满足不同口味。',
];
$demoDesc = generateShortDescription($demoMeta);
echo '<hr><p><strong>关联站点演示描述：</strong>' . safeHtml($demoDesc) . '</p>';