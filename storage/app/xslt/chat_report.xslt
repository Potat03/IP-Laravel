<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:param name="admin_id" select="'0'" />
    <xsl:param name="year_month" select="'0'" />

    <xsl:output method="html" indent="yes" />

    <xsl:template match="/chatCollection">

        <!-- total chat count  created in year_month-->
        <xsl:variable name="chats"
            select="chat[(admin/id = $admin_id or $admin_id = '0') and contains(created_at, $year_month)]" />

        <!-- total chat count -->
        <xsl:variable name="total_chat"
            select="count($chats)" />

        <xsl:variable name="total_duration"
            select="sum($chats/duration)" />

        <!-- cal average duration -->
        <xsl:variable name="avg_duration"
            select="$total_duration div $total_chat" />

        <!-- get total rating -->
        <xsl:variable name="total_rating"
            select="sum($chats/rating)" />


        <div class="report_body_content_wrap">
            <div class="content_wrap_1">
                <div class="chat_rating">
                    <canvas id="chat_rating_chart"></canvas>
                </div>
            </div>
            <div class="content_wrap_2">
                <div class="small_content">
                    <p>Total Chat</p>
                    <h6>
                        <xsl:value-of select="$total_chat" />
                    </h6>
                </div>
                <div class="small_content">
                    <p>Average Chat Duration</p>
                    <h6>
                        <xsl:value-of select="$avg_duration" />
                        <span>(min)</span>
                    </h6>
                </div>
                <div class="small_content">
                    <p>Average Rating</p>
                    <h6>
                        <xsl:value-of select="format-number($total_rating div $total_chat, '0.0')" />
                        <span> out of 5</span>
                    </h6>
                </div>
            </div>
        </div>
        <script> var rate_data = [ <xsl:value-of select="count($chats[rating = 1])" />, <xsl:value-of
                select="count($chats[rating = 2])" />, <xsl:value-of select="count($chats[rating = 3])" />
            , <xsl:value-of select="count($chats[rating = 4])" />, <xsl:value-of
                select="count($chats[rating = 5])" /> ]; generateChart(rate_data); </script>
    </xsl:template>
</xsl:stylesheet>